<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private function getUserData(): array
    {
        $defaultPhoto = 'https://upload.wikimedia.org/wikipedia/commons/2/2c/Default_pfp.svg';

        if (Auth::check()) {
            $u = Auth::user();
            return [
                'username' => $u->username ?? $u->name,
                'fullname' => $u->name,
                'email'    => $u->email,
                'photo'    => $u->photo ?? $defaultPhoto,
            ];
        }

        return [
            'username' => 'naillover',
            'fullname' => 'Nail Lover',
            'email'    => 'naillover@example.com',
            'photo'    => $defaultPhoto,
        ];
    }

    public function index()
    {
        // Data yang dikirim ke Blade
        $data = [
            'user'         => $this->getUserData(),
            'addresses'    => [
                ['id' => 1, 'address' => 'Jl. Telekomunikasi', 'type' => 'shipping'],
                ['id' => 2, 'address' => 'Jl. Mawar', 'type' => 'shipping'],
                ['id' => 3, 'address' => 'Jl. Sukapura No.10', 'type' => 'shipping'],
            ],
            'orderHistory' => [
                ['id' => 101, 'date' => '2025-06-01', 'status' => 'Completed', 'total' => '150000'],
                ['id' => 102, 'date' => '2025-06-15', 'status' => 'Processing', 'total' => '89000'],
            ],
            // Data tambahan untuk navbar (sesuaikan dengan layout kamu)
            'categories'   => [], 
            'isLoggedIn'   => Auth::check(),
            'profile_img'  => $this->getUserData()['photo']
        ];

        return view('profile.index', $data);
    }
}