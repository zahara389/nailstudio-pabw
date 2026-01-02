<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderApiController extends Controller
{
    /**
     * GET /api/orders
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Order::with(['user', 'items.product'])->latest();

        // Member hanya boleh lihat order miliknya
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('order_status', $request->string('status'));
        }

        $orders = $query->get();

        return response()->json($orders->map(fn (Order $order) => $this->formatOrder($order)));
    }

    /**
     * GET /api/orders/{order}
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        if (!$user->isAdmin() && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($this->formatOrder($order));
    }

    /**
     * POST /api/orders
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => ['nullable', 'string', 'max:50'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'proof_of_payment_path' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.discount_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = $request->user();

        $order = DB::transaction(function () use ($validated, $user) {
            $orderDiscount = (float) ($validated['discount_amount'] ?? 0);

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'total_amount' => 0,
                'payment_method' => $validated['payment_method'] ?? null,
                'proof_of_payment_path' => $validated['proof_of_payment_path'] ?? null,
                'order_status' => 'Pending',
                'discount_amount' => $orderDiscount,
            ]);

            [$itemsTotal, $itemsCreated] = $this->syncItems($order, $validated['items']);

            $order->update([
                'total_amount' => max(0, $itemsTotal - $orderDiscount),
            ]);

            // Refresh relasi untuk response
            $order->load(['user', 'items.product']);

            return $order;
        });

        return response()->json([
            'message' => 'Order berhasil dibuat',
            'data' => $this->formatOrder($order),
        ], 201);
    }

    /**
     * PUT/PATCH /api/orders/{order}
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();

        $order = Order::with(['items.product', 'user'])->findOrFail($id);

        if (!$user->isAdmin() && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Admin boleh update status; member hanya boleh update data pembayaran
        $rules = [
            'payment_method' => ['nullable', 'string', 'max:50'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'proof_of_payment_path' => ['nullable', 'string', 'max:255'],
            'items' => ['nullable', 'array', 'min:1'],
            'items.*.product_id' => ['required_with:items', 'exists:products,id'],
            'items.*.quantity' => ['required_with:items', 'integer', 'min:1'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.discount_amount' => ['nullable', 'numeric', 'min:0'],
        ];

        if ($user->isAdmin()) {
            $rules['order_status'] = ['nullable', 'in:Pending,Processing,Shipped,Completed,Cancelled'];
        }

        $validated = $request->validate($rules);

        $updatedOrder = DB::transaction(function () use ($order, $validated, $user) {
            $data = [];

            if (array_key_exists('payment_method', $validated)) {
                $data['payment_method'] = $validated['payment_method'];
            }
            if (array_key_exists('proof_of_payment_path', $validated)) {
                $data['proof_of_payment_path'] = $validated['proof_of_payment_path'];
            }
            if ($user->isAdmin() && array_key_exists('order_status', $validated)) {
                $data['order_status'] = $validated['order_status'];
            }
            if (array_key_exists('discount_amount', $validated)) {
                $data['discount_amount'] = (float) ($validated['discount_amount'] ?? 0);
            }

            if (!empty($data)) {
                $order->update($data);
            }

            if (array_key_exists('items', $validated)) {
                // Replace items dan hitung ulang total
                $order->items()->delete();
                [$itemsTotal] = $this->syncItems($order, $validated['items']);

                $order->update([
                    'total_amount' => max(0, $itemsTotal - (float) $order->discount_amount),
                ]);
            }

            $order->load(['user', 'items.product']);

            return $order;
        });

        return response()->json([
            'message' => 'Order berhasil diperbarui',
            'data' => $this->formatOrder($updatedOrder),
        ]);
    }

    /**
     * DELETE /api/orders/{order}
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $order = Order::findOrFail($id);

        if (!$user->isAdmin() && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->delete();

        return response()->json(['message' => 'Order berhasil dihapus']);
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . Str::upper(Str::random(8));
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @return array{0: float, 1: int}
     */
    private function syncItems(Order $order, array $items): array
    {
        $total = 0.0;
        $count = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                throw ValidationException::withMessages([
                    'items' => 'Produk tidak ditemukan.',
                ]);
            }

            $quantity = (int) $item['quantity'];
            $unitPrice = (float) ($item['unit_price'] ?? $product->final_price ?? $product->price);
            $itemDiscount = (float) ($item['discount_amount'] ?? 0);

            $subtotal = $quantity * max(0, $unitPrice - $itemDiscount);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'discount_amount' => $itemDiscount,
                'subtotal_item' => $subtotal,
            ]);

            $total += $subtotal;
            $count++;
        }

        return [$total, $count];
    }

    private function formatOrder(Order $order): array
    {
        return [
            'id' => $order->id,
            'user' => $order->relationLoaded('user') && $order->user
                ? [
                    'id' => $order->user->id,
                    'name' => $order->user->name,
                    'username' => $order->user->username,
                    'email' => $order->user->email,
                    'role' => $order->user->role,
                ]
                : null,
            'order_number' => $order->order_number,
            'total_amount' => (float) $order->total_amount,
            'discount_amount' => (float) $order->discount_amount,
            'payment_method' => $order->payment_method,
            'proof_of_payment_path' => $order->proof_of_payment_path,
            'order_status' => $order->order_status,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
            'items' => $order->relationLoaded('items')
                ? $order->items->map(function (OrderItem $item) {
                    $product = $item->relationLoaded('product') ? $item->product : null;

                    return [
                        'id' => $item->id,
                        'product' => $product ? [
                            'id' => $product->id,
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'image_url' => $product->image_url ?? null,
                        ] : null,
                        'quantity' => (int) $item->quantity,
                        'unit_price' => (float) $item->unit_price,
                        'discount_amount' => (float) $item->discount_amount,
                        'subtotal_item' => (float) $item->subtotal_item,
                    ];
                })->values()
                : [],
        ];
    }
}
