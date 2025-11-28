<?php

namespace App\Livewire; // PASTI HARUS App\Livewire

use Livewire\Component;

class Navbar extends Component
{
    // Properti publik untuk mengontrol status modal dan data keranjang
    public $isCategoryModalOpen = false;
    public $isCartModalOpen = false;
    public $cartItemCount = 0; // Contoh data dinamis

    /**
     * Metode mount() dipanggil saat komponen diinisialisasi.
     */
    public function mount()
    {
        // Di sini Anda bisa mengambil jumlah item keranjang dari session atau database
        // Contoh: $this->cartItemCount = session('cart_count', 0);
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
        // Mengarahkan ke resources/views/livewire/navbar.blade.php
        return view('livewire.navbar');
    }
}