@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/filecssnya.css') }}">

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-900">Your Account</h1>
    </div>

    <div class="bg-white rounded-xl p-6 mb-8 shadow-sm border border-gray-100">
        <div class="flex items-center gap-4">
            <div class="profile-photo-container">
                {{-- Gunakan fallback jika photo kosong --}}
                <img src="{{ $user['photo'] }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-2 border-pink-500">
            </div>
            <div>
                <h2 class="font-semibold text-xl text-gray-800">{{ $user['fullname'] }}</h2>
                <p class="text-sm text-gray-500">{{ $user['email'] }}</p>
                <span class="text-xs bg-pink-100 text-pink-600 px-2 py-1 rounded-full">@ {{ $user['username'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order History</h2>
                @if(empty($orderHistory))
                    <p class="text-sm text-gray-600 italic">No orders found.</p>
                @else
                    <div class="overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @foreach($orderHistory as $order)
                                <li class="py-4 flex justify-between items-center hover:bg-gray-50 transition px-2 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Order #{{ $order['id'] }}</p>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order['date'])->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold">Rp {{ number_format($order['total'], 0, ',', '.') }}</p>
                                        <span class="px-2 py-1 rounded text-xs {{ $order['status'] == 'Completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Saved Addresses</h3>
                <ul class="space-y-3">
                    @foreach($addresses as $addr)
                        <li class="text-sm p-3 border border-gray-50 rounded-lg bg-gray-50">
                            <span class="block font-bold text-gray-700 text-xs uppercase">{{ $addr['type'] }}</span>
                            {{ $addr['address'] }}
                        </li>
                    @endforeach
                </ul>
                <hr class="my-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Quick Actions</h3>
                <ul class="space-y-2 text-sm text-pink-600 font-medium">
                    <li><a href="/account-settings" class="hover:text-pink-800">⚙️ Account Settings</a></li>
                    <li><a href="/address" class="hover:text-pink-800">📍 Manage Addresses</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection