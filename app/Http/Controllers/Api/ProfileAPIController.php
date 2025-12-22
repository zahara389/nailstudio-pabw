<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileAPIController extends Controller
{
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

        return [
            'username' => 'naillover',
            'fullname' => 'Nail Lover',
            'email'    => 'naillover@example.com',
            'photo'    => $defaultPhoto,
        ];
    }

    private function getAddresses(): array
    {
        return [
            ['id' => 1, 'address' => 'Jl. Telekomunikasi',  'type' => 'shipping'],
            ['id' => 2, 'address' => 'Jl. Mawar',           'type' => 'shipping'],
            ['id' => 3, 'address' => 'Jl. Sukapura No.10',  'type' => 'shipping'],
        ];
    }

    private function getOrderHistory(): array
    {
        return [
            ['id' => 101, 'date' => '2025-06-01', 'status' => 'Completed',  'total' => '150000'],
            ['id' => 102, 'date' => '2025-06-15', 'status' => 'Processing', 'total' => '89000'],
        ];
    }

    /**
     * GET /api/profile
     */
    public function show()
    {
        return response()->json([
            'user'         => $this->getUserData(),
            'addresses'    => $this->getAddresses(),
            'orderHistory' => $this->getOrderHistory(),
        ]);
    }

    /**
     * GET /api/profile/addresses
     */
    public function addresses()
    {
        return response()->json($this->getAddresses());
    }

    /**
     * GET /api/profile/orders
     */
    public function orders()
    {
        return response()->json($this->getOrderHistory());
    }
}
