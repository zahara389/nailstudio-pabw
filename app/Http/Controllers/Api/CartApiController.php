<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartApiController extends Controller
{
    /**
     * ===============================
     * GET /api/cart
     * ===============================
     */
    public function index(Request $request)
    {
        $user = $request->user(); 

        $cart = Cart::with(['items.product'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        return response()->json([
            'items' => $cart ? $cart->items : [],
        ]);
    }

    /**
     * ===============================
     * POST /api/cart/add
     * ===============================
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $user = $request->user();

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1) {
            return response()->json([
                'message' => 'Stok produk tidak tersedia',
            ], 422);
        }

        $cart = Cart::firstOrCreate(
            [
                'user_id' => $user->id,
                'status'  => 'active',
            ],
            ['status' => 'active']
        );

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
                'unit_price' => $product->final_price ?? $product->price,
            ]);
        }

        return response()->json([
            'message' => 'Produk ditambahkan ke keranjang',
        ]);
    }

    /**
     * ===============================
     * PUT /api/cart/item/{id}
     * ===============================
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        $item = CartItem::with('cart')->findOrFail($id);

        if ($item->cart->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $item->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'message' => 'Jumlah item diperbarui',
        ]);
    }

    /**
     * ===============================
     * DELETE /api/cart/item/{id}
     * ===============================
     */
    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $item = CartItem::with('cart')->findOrFail($id);

        if ($item->cart->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json([
            'message' => 'Item dihapus dari keranjang',
        ]);
    }

    /**
     * ===============================
     * POST /api/cart/checkout
     * ===============================
     */
    public function checkout(Request $request)
    {
        $user = $request->user();

        $cart = Cart::with(['items.product'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Keranjang masih kosong',
            ], 422);
        }

        $order = DB::transaction(function () use ($cart, $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . Str::upper(Str::random(8)),
                'total_amount' => 0,
                'payment_method' => null,
                'proof_of_payment_path' => null,
                'order_status' => 'Pending',
                'discount_amount' => 0,
            ]);

            $total = 0.0;

            foreach ($cart->items as $cartItem) {
                /** @var CartItem $cartItem */
                $product = $cartItem->product;

                if (! $product) {
                    $product = Product::find($cartItem->product_id);
                }

                if (! $product) {
                    return response()->json([
                        'message' => 'Produk tidak ditemukan di keranjang',
                    ], 422);
                }

                $quantity = (int) $cartItem->quantity;

                if ($product->stock < $quantity) {
                    return response()->json([
                        'message' => 'Stok produk tidak mencukupi',
                        'product_id' => $product->id,
                        'available_stock' => (int) $product->stock,
                    ], 422);
                }

                $unitPrice = (float) ($cartItem->unit_price ?? $product->final_price ?? $product->price);
                $subtotal = $quantity * $unitPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_amount' => 0,
                    'subtotal_item' => $subtotal,
                ]);

                $product->decrement('stock', $quantity);
                $total += $subtotal;
            }

            $order->update([
                'total_amount' => $total,
            ]);

            $cart->update(['status' => 'checked_out']);
            $cart->items()->delete();

            $order->load(['items.product']);

            return $order;
        });

        // Jika transaction callback mengembalikan JsonResponse (stok kurang, dll), return langsung.
        if ($order instanceof \Illuminate\Http\JsonResponse) {
            return $order;
        }

        return response()->json([
            'message' => 'Checkout berhasil, order dibuat',
            'data' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => (float) $order->total_amount,
                'order_status' => $order->order_status,
            ],
        ], 201);
    }
}
