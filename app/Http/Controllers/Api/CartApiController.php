<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    /**
     * ===============================
     * GET /api/cart
     * ===============================
     */
    public function index(Request $request)
    {
        $user = $request->user(); // ✅ PALING AMAN

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
    public function checkout()
    {
        return response()->json([
            'message' => 'Checkout diproses',
        ]);
    }
}
