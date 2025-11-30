<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function update(Request $request, CartItem $item): RedirectResponse
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

        return back()->with('success', 'Jumlah produk di keranjang diperbarui.');
    }

    public function destroy(Request $request, CartItem $item): RedirectResponse
    {
        $this->authorizeItem($request, $item);

        $item->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

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

    private function authorizeItem(Request $request, CartItem $item): void
    {
        $item->loadMissing('cart');

        if ($item->cart->user_id !== $request->user()->id) {
            abort(403);
        }
    }

    private function resolveUnitPrice(Product $product): float
    {
        $finalPrice = $product->final_price ?? $product->price;

        return (float) $finalPrice;
    }

    private function prepareCartItemPresentation(CartItem $item): void
    {
        $product = $item->product;

        if (! $product) {
            return;
        }

        $product->setAttribute('image_url', $this->resolveProductImage($product->image));
        $product->setAttribute('category_label', Str::headline($product->category ?? 'Produk'));
    }

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

    private function fallbackImage(): string
    {
        return 'https://via.placeholder.com/640x480?text=Nail+Art';
    }

    private function configureMidtrans(): void
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$clientKey = config('midtrans.client_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production', false);
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }

    private function getActiveCart(Request $request): ?Cart
    {
        return Cart::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->first();
    }
}
