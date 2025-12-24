<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
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

    public function index(Request $request)
    {
        $user = $request->user();

        $addresses = $user
            ? $user->addresses()->latest()->get()
            : collect();

        $recentOrders = $user
            ? Order::query()
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get()
            : collect();

        $userData = $this->getUserData();

        $data = [
            'user' => $userData,
            'addresses' => $addresses,
            'recentOrders' => $recentOrders,
            // Data tambahan untuk navbar (sesuaikan dengan layout kamu)
            'categories' => [],
            'isLoggedIn' => Auth::check(),
            'profile_img' => $userData['photo'],
        ];

        return view('profile.index', $data);
    }
}