<?php

namespace App\Livewire; // PASTI HARUS App\Livewire

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    // Properti publik untuk mengontrol status modal dan data keranjang
    public $isCategoryModalOpen = false;
    public $isCartModalOpen = false;
    public $cartItemCount = 0;
    public $cartItems = [];
    public $cartSubtotal = 0;

    /**
     * Metode mount() dipanggil saat komponen diinisialisasi.
     */
    public function mount(): void
    {
        $this->refreshCartData();
    }

    // Mengganti JS Function openCategoryModal
    public function openCategoryModal()
    {
        $this->isCategoryModalOpen = true;
        $this->isCartModalOpen = false;
    }

    // Mengganti JS Function openCartModal
    public function openCartModal()
    {
        $this->isCartModalOpen = true;
        $this->isCategoryModalOpen = false;
    }

    // Mengganti JS Function closeAllModals
    public function closeAllModals()
    {
        $this->isCategoryModalOpen = false;
        $this->isCartModalOpen = false;
    }

    /**
     * Metode render() mengarahkan ke file view.
     */
    public function render()
    {
        return view('livewire.navbar');
    }

    #[On('cart-updated')]
    public function refreshCartData(): void
    {
        if (! Auth::check()) {
            $this->cartItemCount = 0;
            $this->cartItems = [];
            $this->cartSubtotal = 0;

            return;
        }

        $cart = Cart::with(['items.product'])
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        $items = $cart?->items ?? collect();

        $this->cartItemCount = $items->sum('quantity');
        $this->cartSubtotal = $items->sum(fn ($item) => $item->quantity * $item->unit_price);

        $this->cartItems = $items->map(function ($item) {
            $product = $item->product;
            $stock = $product?->stock;

            return [
                'id' => $item->id,
                'product_name' => $product->name ?? 'Produk Nail Studio',
                'category_label' => $product?->category ? Str::headline($product->category) : 'Signature',
                'quantity' => (int) $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'line_total' => (float) ($item->quantity * $item->unit_price),
                'image_url' => $this->resolveProductImage($product->image ?? null),
                'max_quantity' => $stock !== null ? max(1, (int) $stock) : (int) $item->quantity,
            ];
        })->values()->toArray();
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
        return 'https://via.placeholder.com/120x120?text=Nail+Art';
    }
}