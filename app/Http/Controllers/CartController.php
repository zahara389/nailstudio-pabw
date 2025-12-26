<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class CartController extends Controller
{
    // Pastikan semua route cart hanya bisa diakses user login
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Halaman utama keranjang
    public function index(Request $request)
    {
        $cart = $this->getActiveCart($request);
        $items = $cart?->items ?? collect();

        $items->each(fn (CartItem $item) => $this->prepareCartItemPresentation($item));

        $subtotal = $items->sum(fn (CartItem $item) => $item->quantity * $item->unit_price);

        return view('cart.index', [
            'cart' => $cart,
            'items' => $items,
            'subtotal' => $subtotal,
            'isEmpty' => $items->isEmpty(),
        ]);
        
    }

    // Halaman checkout sebelum Midtrans
    public function checkout(Request $request)
    {
        $cart = $this->getActiveCart($request);

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('alert', 'Keranjang Anda masih kosong.');
        }

        $cart->items->each(fn (CartItem $item) => $this->prepareCartItemPresentation($item));
        $subtotal = $cart->items->sum(fn (CartItem $item) => $item->quantity * $item->unit_price);

        return view('cart.checkout', [
            'cart' => $cart,
            'items' => $cart->items,
            'subtotal' => $subtotal,
            'clientKey' => config('midtrans.client_key'),
            'user' => $request->user(),
        ]);
    }

    // Tambah produk ke keranjang
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < 1) {
            return back()->withErrors([
                'quantity' => 'Stok produk tidak tersedia saat ini.',
            ])->withInput();
        }

        $cart = Cart::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'status' => 'active',
            ],
            [
                'status' => 'active',
            ]
        );

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        $requestedQuantity = (int) $validated['quantity'];
        $maxQuantity = max(0, (int) $product->stock);

        if ($requestedQuantity > $maxQuantity) {
            $requestedQuantity = $maxQuantity;
        }

        if ($requestedQuantity < 1) {
            return back()->withErrors([
                'quantity' => 'Jumlah yang diminta melebihi stok yang tersedia.',
            ])->withInput();
        }

        if ($cartItem) {
            $newQuantity = min($maxQuantity, $cartItem->quantity + $requestedQuantity);
            $cartItem->update([
                'quantity' => $newQuantity,
                'unit_price' => $this->resolveUnitPrice($product),
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $requestedQuantity,
                'unit_price' => $this->resolveUnitPrice($product),
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Update kuantitas item tertentu
    public function update(Request $request, CartItem $item)
    {
        $this->authorizeItem($request, $item);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item->loadMissing('product');

        $productStock = $item->product?->stock;
        $maxQuantity = $productStock !== null ? max(1, (int) $productStock) : $validated['quantity'];
        $quantity = min($maxQuantity, $validated['quantity']);

        $item->update([
            'quantity' => $quantity,
        ]);

        return $this->respondWithCartState($request, $item->cart, 'Jumlah produk di keranjang diperbarui.');
    }

    // Hapus item dari keranjang
    public function destroy(Request $request, CartItem $item)
    {
        $this->authorizeItem($request, $item);

        $cart = $item->cart;

        $item->delete();

        return $this->respondWithCartState($request, $cart, 'Produk dihapus dari keranjang.');
    }

    // Generate Snap token untuk proses pembayaran Midtrans
    public function processCheckout(Request $request): JsonResponse
    {
        $cart = $this->getActiveCart($request);

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Keranjang Anda masih kosong.',
            ], 422);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        foreach ($cart->items as $cartItem) {
            $productStock = $cartItem->product?->stock;

            if ($productStock !== null && $productStock < $cartItem->quantity) {
                return response()->json([
                    'message' => 'Stok untuk ' . ($cartItem->product->name ?? 'produk') . ' tidak mencukupi.',
                ], 422);
            }
        }

        $grossAmount = $cart->items->sum(fn (CartItem $item) => $item->quantity * $item->unit_price);

        $this->configureMidtrans();

        $orderId = sprintf('NS-%s-%s', now()->format('YmdHis'), Str::upper(Str::random(4)));

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) round($grossAmount),
            ],
            'item_details' => $cart->items->map(function (CartItem $item) {
                $productName = $item->product->name ?? 'Produk Nail Studio';

                return [
                    'id' => (string) $item->product_id,
                    'price' => (int) round($item->unit_price),
                    'quantity' => (int) $item->quantity,
                    'name' => Str::limit($productName, 50),
                ];
            })->values()->toArray(),
            'customer_details' => [
                'first_name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'billing_address' => [
                    'first_name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ],
                'shipping_address' => [
                    'first_name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ],
            ],
            'custom_field1' => $validated['notes'] ?? '',
        ];

        try {
            $snapTransaction = Snap::createTransaction($payload);

            return response()->json([
                'snap_token' => $snapTransaction->token ?? null,
                'redirect_url' => $snapTransaction->redirect_url ?? null,
                'order_id' => $orderId,
            ]);
        } catch (\Throwable $exception) {
            Log::error('Midtrans checkout gagal', [
                'message' => $exception->getMessage(),
                'user_id' => $request->user()->id,
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
            ], 500);
        }
    }

    // Pastikan item milik user terkait
    private function authorizeItem(Request $request, CartItem $item): void
    {
        $item->loadMissing('cart');

        if ($item->cart->user_id !== $request->user()->id) {
            abort(403);
        }
    }

    // Hitung harga final produk (diskon atau harga default)
    private function resolveUnitPrice(Product $product): float
    {
        $finalPrice = $product->final_price ?? $product->price;

        return (float) $finalPrice;
    }

    // Siapkan atribut presentasi untuk view cart
    private function prepareCartItemPresentation(CartItem $item): void
    {
        $product = $item->product;

        if (! $product) {
            return;
        }

        $product->setAttribute('image_url', $this->resolveProductImage($product->image));
        $product->setAttribute('category_label', Str::headline($product->category ?? 'Produk'));
    }

    // Normalisasi path gambar produk
    private function resolveProductImage(?string $imagePath): string
    {
        if (! $imagePath) {
            return $this->fallbackImage();
        }

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        if (Str::startsWith($imagePath, ['storage/', 'images/', 'img/', 'uploads/'])) {
            return asset($imagePath);
        }

        return asset('storage/' . ltrim($imagePath, '/'));
    }

    // Placeholder ketika gambar tidak ada
    private function fallbackImage(): string
    {
        return 'https://via.placeholder.com/640x480?text=Nail+Art';
    }

    // Response seragam untuk AJAX/non-AJAX setelah update keranjang
    private function respondWithCartState(Request $request, ?Cart $cart, string $message)
    {
        if ($request->expectsJson()) {
            $cart?->loadMissing('items');
            $items = $cart?->items ?? collect();

            $count = $items->sum(fn (CartItem $cartItem) => $cartItem->quantity);
            $subtotal = $items->sum(fn (CartItem $cartItem) => $cartItem->quantity * $cartItem->unit_price);

            return response()->json([
                'message' => $message,
                'cart' => [
                    'count' => $count,
                    'subtotal' => $subtotal,
                ],
            ]);
        }

        return back()->with('success', $message);
    }

    // Konfigurasi kredensial Midtrans
    private function configureMidtrans(): void
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$clientKey = config('midtrans.client_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production', false);
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }

    // Ambil keranjang aktif milik user
    private function getActiveCart(Request $request): ?Cart
    {
        return Cart::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->first();
    }

    /**
     * Process QRIS payment dengan upload bukti bayar
     * Mengurangi stok dan membuat order
     */
    public function processQrisPayment(Request $request): RedirectResponse
    {
        $cart = $this->getActiveCart($request);

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('alert', 'Keranjang kosong atau tidak ditemukan.');
        }

        $validated = $request->validate([
            'selected_address' => ['required', 'exists:addresses,id'],
            'bukti_bayar' => ['required', 'image', 'max:5120'], // max 5MB
        ]);

        try {
            // Verifikasi address milik user
            $address = $request->user()->addresses()->findOrFail($validated['selected_address']);

            // Check stok semua item
            foreach ($cart->items as $cartItem) {
                $productStock = $cartItem->product?->stock;

                if ($productStock === null || $productStock < $cartItem->quantity) {
                    return back()->withErrors([
                        'stock' => 'Stok untuk ' . ($cartItem->product->name ?? 'produk') . ' tidak mencukupi.',
                    ]);
                }
            }

            // Upload bukti bayar
            $proofPath = null;
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $proofPath = $file->store('proof_of_payments', 'public');
            }

            // Hitung total
            $subtotal = $cart->items->sum(fn (CartItem $item) => $item->quantity * $item->unit_price);

            // Start transaction
            DB::beginTransaction();

            try {
                // Create order
                $order = $request->user()->orders()->create([
                    'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . Str::random(6),
                    'total_amount' => $subtotal,
                    'payment_method' => 'qris',
                    'proof_of_payment_path' => $proofPath,
                    'order_status' => 'pending',
                ]);

                // Reduce stock dan create order items
                foreach ($cart->items as $cartItem) {
                    $product = $cartItem->product;

                    $quantity = (int) $cartItem->quantity;
                    $unitPrice = (float) $cartItem->unit_price;
                    $discountAmount = 0.0;
                    $subtotalItem = $quantity * max(0, $unitPrice - $discountAmount);

                    // Create order item
                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'discount_amount' => $discountAmount,
                        'subtotal_item' => $subtotalItem,
                    ]);

                    // Reduce stock
                    $product->decrement('stock', $quantity);
                }

                // Update cart status menjadi checked_out (sesuai enum di migration)
                $cart->update(['status' => 'checked_out']);

                // Clear all items dari cart
                $cart->items()->delete();

                DB::commit();

                // Redirect ke halaman Payment Success
                return redirect()->route('payment.success')
                    ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');

            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Throwable $e) {
            Log::error('QRIS payment error', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()->id,
            ]);

            return back()->withErrors([
                'payment' => 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
            ]);
        }
    }
}
