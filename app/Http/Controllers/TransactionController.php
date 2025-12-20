<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('admin.transaction-history', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'pembeli' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'order_status' => ['nullable', 'in:Pending,Processing,Shipped,Completed,Cancelled'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'proof_of_payment_path' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'exists:products,id'],
            'items.*.nama_produk' => ['nullable', 'string'],
            'items.*.namaproduct' => ['nullable', 'string'],
            'items.*.product_slug' => ['nullable', 'string'],
            'items.*.slug' => ['nullable', 'string'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1'],
            'items.*.qty' => ['nullable', 'integer', 'min:1'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.harga' => ['nullable', 'numeric', 'min:0'],
            'items.*.discount_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        return DB::transaction(function () use ($validated) {
            $userId = $validated['user_id']
                ?? $this->resolveUserId($validated['pembeli'] ?? null)
                ?? Auth::id();

            if (!$userId) {
                throw ValidationException::withMessages([
                    'user_id' => 'Pilih pengguna yang valid sebelum membuat transaksi.',
                ]);
            }
            $orderNumber = 'ORD-' . Str::upper(Str::random(8));

            $orderDiscount = $validated['discount_amount'] ?? 0;

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'total_amount' => 0,
                'payment_method' => $validated['payment_method'] ?? null,
                'proof_of_payment_path' => $validated['proof_of_payment_path'] ?? null,
                'order_status' => $validated['order_status'] ?? 'Pending',
                'discount_amount' => $orderDiscount,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = $this->resolveProduct($item);

                if (!$product) {
                    $requestedName = $item['nama_produk']
                        ?? $item['namaproduct']
                        ?? (!empty($item['product_id']) ? '#'.$item['product_id'] : 'unknown product');

                    throw ValidationException::withMessages([
                        'items' => "Produk {$requestedName} tidak ditemukan. Perbarui data produk terlebih dahulu.",
                    ]);
                }

                $quantity = $item['quantity'] ?? $item['qty'] ?? 1;
                $unitPrice = $item['unit_price'] ?? $item['harga'] ?? $product->price;
                $itemDiscount = $item['discount_amount'] ?? 0;
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
            }

            $order->update([
                'total_amount' => max(0, $total - $orderDiscount),
            ]);

            return redirect()
                ->route('transaction.history')
                ->with('success', 'Transaksi berhasil disimpan!');
        });
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Transaksi berhasil dihapus!');
    }

    private function resolveUserId(?string $name): ?int
    {
        if (!$name) {
            return null;
        }

        return User::where('name', $name)->value('id');
    }

    private function resolveProduct(array $item): ?Product
    {
        if (!empty($item['product_id'])) {
            return Product::find($item['product_id']);
        }

        $slug = $item['slug'] ?? $item['product_slug'] ?? null;

        if ($slug) {
            return Product::where('slug', $slug)->first();
        }

        $name = $item['nama_produk'] ?? $item['namaproduct'] ?? null;

        if ($name) {
            return Product::where('name', $name)->first();
        }

        return null;
    }
}
