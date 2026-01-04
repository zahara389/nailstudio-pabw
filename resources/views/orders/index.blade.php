@extends('layouts.app')

@section('title', 'My Orders | Nail Studio')

@section('content')
<div class="max-w-4xl mx-auto pt-20 pb-20 px-4">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Order History</h1>
            <p class="text-gray-500 mt-1">Lacak dan kelola pesanan Nail Studio Anda</p>
        </div>
        <div class="hidden md:block">
            <span class="text-sm text-gray-400">Total: {{ $orders->total() }} Pesanan</span>
        </div>
    </div>

    @if ($orders->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
            <div class="w-20 h-20 bg-pink-50 text-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shopping-bag text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Belum ada pesanan</h3>
            <p class="text-gray-500 mt-2 mb-6">Sepertinya Anda belum melakukan pembelian apapun.</p>
            <a href="{{ route('landing.index') }}" class="inline-flex items-center px-6 py-3 bg-pink-600 text-white font-bold rounded-xl hover:bg-pink-700 transition-all">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($orders as $order)
                @php
                    $statusRaw = strtolower($order->order_status ?? '');
                    $statusMap = [
                        'pending'    => ['color' => 'bg-amber-100 text-amber-700 border-amber-200', 'label' => 'Menunggu'],
                        'processing' => ['color' => 'bg-blue-100 text-blue-700 border-blue-200', 'label' => 'Diproses'],
                        'shipped'    => ['color' => 'bg-indigo-100 text-indigo-700 border-indigo-200', 'label' => 'Dikirim'],
                        'completed'  => ['color' => 'bg-emerald-100 text-emerald-700 border-emerald-200', 'label' => 'Selesai'],
                        'cancelled'  => ['color' => 'bg-rose-100 text-rose-700 border-rose-200', 'label' => 'Batal'],
                    ];
                    $currentStatus = $statusMap[$statusRaw] ?? ['color' => 'bg-gray-100 text-gray-700 border-gray-200', 'label' => $order->order_status];
                @endphp

                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
                    <div class="bg-gray-50/50 px-6 py-4 flex flex-wrap items-center justify-between gap-4 border-b border-gray-100">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-bold text-gray-900">#{{ $order->order_number }}</span>
                            <span class="text-gray-300">|</span>
                            <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $currentStatus['color'] }}">
                            {{ $currentStatus['label'] }}
                        </span>
                    </div>

                    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-100 flex-shrink-0 overflow-hidden">
                                @php
                                    $firstItem = $order->items->first();
                                    $productImagePath = $firstItem?->product?->image;
                                    $productImageUrl = $productImagePath
                                        ? (filter_var($productImagePath, FILTER_VALIDATE_URL) ? $productImagePath : asset($productImagePath))
                                        : null;
                                @endphp

                                @if($productImageUrl)
                                    <img src="{{ $productImageUrl }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs text-center p-1">No Image</div>
                                @endif
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 line-clamp-1">
                                    {{ $order->items->first()->product->name ?? 'Produk' }} 
                                    @if($order->items->count() > 1)
                                        <span class="text-gray-400 font-normal"> & {{ $order->items->count() - 1 }} produk lainnya</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $order->items->map(fn($i) => $i->quantity . 'x ' . ($i->product->name ?? 'Produk'))->implode(', ') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between md:flex-col md:items-end gap-2 border-t md:border-t-0 pt-4 md:pt-0">
                            <div>
                                <p class="text-xs text-gray-400 md:text-right uppercase tracking-wider font-bold">Total Pembayaran</p>
                                <p class="text-xl font-black text-pink-700">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-pink-200 text-pink-600 text-sm font-bold rounded-xl hover:bg-pink-600 hover:text-white transition-all shadow-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection