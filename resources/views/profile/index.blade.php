@extends('layouts.app')

@section('content')
<!-- Memuat CSS kustom untuk profil -->
<link rel="stylesheet" href="{{ asset('css/filecssnya.css') }}">

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-900">Your Account</h1>
    </div>

    <!-- Informasi Profil -->
    <div class="bg-white rounded-xl p-6 mb-8 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="profile-photo-container">
                <img src="{{ $user['photo'] }}" alt="Profile" class="profile-photo-img">
            </div>
            <div>
                <h2 class="font-semibold text-lg">{{ $user['fullname'] }}</h2>
                <p class="text-sm text-gray-500">{{ $user['email'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Konten Utama: Riwayat Pesanan -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order History</h2>
                @if(empty($orderHistory))
                    <p class="text-sm text-gray-600">No orders found.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($orderHistory as $order)
                            <li class="py-2 flex justify-between items-center">
                                <span>Order #{{ $order['id'] }} - {{ $order['date'] }}</span>
                                <span class="font-medium text-sm capitalize">{{ strtolower($order['status']) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Sidebar dengan tindakan -->
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="{{ url('/account-settings') }}" class="text-pink-600 hover:underline">Account Settings</a>
                </li>
                <li>
                    <a href="{{ url('/address') }}" class="text-pink-600 hover:underline">Manage Addresses</a>
                </li>
                <li>
                    <a href="{{ url('/checkout') }}" class="text-pink-600 hover:underline">Checkout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
