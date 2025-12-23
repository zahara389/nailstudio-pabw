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
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Order History</h2>
                    <a href="{{ route('orders.index') }}" class="text-sm font-medium text-pink-600 hover:text-pink-800">Lihat semua</a>
                </div>

                @if(($recentOrders ?? collect())->isEmpty())
                    <p class="text-sm text-gray-600 italic">No orders found.</p>
                @else
                    <div class="overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @foreach($recentOrders as $order)
                                @php
                                    $status = (string) ($order->order_status ?? 'pending');
                                    $badgeClass = match ($status) {
                                        'completed' => 'bg-green-100 text-green-700',
                                        'paid' => 'bg-blue-100 text-blue-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        'failed' => 'bg-red-100 text-red-700',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    };

                                    $orderLabel = $order->order_number ?: ('#' . $order->id);
                                @endphp

                                <li class="py-4 flex justify-between items-center hover:bg-gray-50 transition px-2 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Order {{ $orderLabel }}</p>
                                        <p class="text-xs text-gray-500">{{ optional($order->created_at)->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right flex items-center gap-3">
                                        <div>
                                            <p class="text-sm font-semibold">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</p>
                                            <span class="px-2 py-1 rounded text-xs {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                        </div>
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-sm font-medium text-pink-600 hover:text-pink-800 whitespace-nowrap">Detail</a>
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
                @if(($addresses ?? collect())->isEmpty())
                    <p class="text-sm text-gray-600 italic">Belum ada alamat tersimpan.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($addresses as $addr)
                            <li class="text-sm p-3 border border-gray-50 rounded-lg bg-gray-50">
                                <span class="block font-bold text-gray-700 text-xs uppercase">{{ $addr->type }}</span>
                                {{ $addr->address }}
                            </li>
                        @endforeach
                    </ul>
                @endif
                <hr class="my-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('orders.index') }}" class="block w-full text-center text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded-lg">Riwayat Pesanan</a>
                    <a href="{{ route('address.index') }}" class="block w-full text-center text-sm font-medium text-pink-700 bg-pink-50 hover:bg-pink-100 px-4 py-2 rounded-lg">Kelola Alamat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection