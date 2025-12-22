<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk halaman profil pengguna.
 *
 * Data pengguna, riwayat pesanan, dan alamat disiapkan sebagai contoh.
 * Dalam implementasi nyata, data-data ini sebaiknya diambil dari model
 * atau service layer.
 */
class ProfileController extends Controller
{
    /**
     * Data untuk Navbar agar konsisten dengan halaman lain.
     *
     * @return array
     */
    private function getNavbarData(): array
    {
        // Gunakan rute produk yang sudah ada untuk kategori
        $categories = [
            [
                'name' => 'Nail Polish',
                'url'  => route('products.index', ['category' => 'nail-polish']),
                'img'  => 'https://storage.googleapis.com/a1aa/image/3454039a-1ec0-4d5b-d768-5eb40bc6fdf3.jpg',
                'alt'  => 'Nail Polish',
            ],
            [
                'name' => 'Nail Tools',
                'url'  => route('products.index', ['category' => 'nail-tools']),
                'img'  => 'https://storage.googleapis.com/a1aa/image/19a38516-0222-4fe4-e0e8-8b6788672e73.jpg',
                'alt'  => 'Nail Tools',
            ],
        ];

        $isLoggedIn  = Auth::check();
        $favCount    = 3;
        $totalItems  = 2;
        $profile_img = $this->getUserData()['photo'];

        return compact('categories', 'isLoggedIn', 'favCount', 'totalItems', 'profile_img');
    }

    /**
     * Ambil data user dari Auth bila tersedia, fallback ke dummy.
     */
    private function getUserData(): array
    {
        $defaultPhoto = 'https://upload.wikimedia.org/wikipedia/commons/2/2c/Default_pfp.svg';

        if (Auth::check()) {
            $u = Auth::user();
            return [
                'username' => $u->username ?? ($u->name ?? 'user'),
                'fullname' => $u->name ?? 'User',
                'email'    => $u->email ?? 'user@example.com',
                'photo'    => $u->photo ?? $defaultPhoto,
            ];
        }

        // Dummy jika belum login
        return [
            'username' => 'naillover',
            'fullname' => 'Nail Lover',
            'email'    => 'naillover@example.com',
            'photo'    => $defaultPhoto,
        ];
    }

    /**
     * Dummy shipping addresses
     */
    private function getAddresses(): array
    {
        return [
            ['id' => 1, 'address' => 'Jl. Telekomunikasi',  'type' => 'shipping'],
            ['id' => 2, 'address' => 'Jl. Mawar',           'type' => 'shipping'],
            ['id' => 3, 'address' => 'Jl. Sukapura No.10',  'type' => 'shipping'],
        ];
    }

    /**
     * Dummy order history
     */
    private function getOrderHistory(): array
    {
        return [
            ['id' => 101, 'date' => '2025-06-01', 'status' => 'Completed',  'total' => '150000'],
            ['id' => 102, 'date' => '2025-06-15', 'status' => 'Processing', 'total' => '89000'],
        ];
    }

    /**
     * Tampilkan halaman profil.
     */
    public function index()
    {
        $data = array_merge($this->getNavbarData(), [
            'user'         => $this->getUserData(),
            'addresses'    => $this->getAddresses(),
            'orderHistory' => $this->getOrderHistory(),
        ]);

        return view('profile.index', $data);
    }
}
