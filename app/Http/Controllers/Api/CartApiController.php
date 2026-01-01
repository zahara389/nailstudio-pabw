<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartApiController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1) {
            return response()->json([
                'message' => 'Stok produk tidak tersedia',
            ], 422);
        }

        $cart = Cart::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'status' => 'active',
            ],
            ['status' => 'active']
        );

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->final_price ?? $product->price,
            ]);
        }

        return response()->json([
            'message' => 'Produk ditambahkan ke keranjang',
        ]);
    }

    public function checkout(Request $request)
    {
        // Untuk sekarang: cukup trigger logic checkout web
        // atau redirect ke flow Midtrans/Qris
        return response()->json([
            'message' => 'Checkout diproses, lanjutkan ke pembayaran',
        ]);
    }
}
