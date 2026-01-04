@extends('layouts.app')

@section('title', 'Order Detail | Nail Studio')

@push('styles')
    <style>
        .ns-progress-line {
            height: 0.375rem;
        }
    </style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-4 text-pink-700">Order Detail {{ $order->order_number }}</h1>

    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Status:</strong> {{ $order->order_status }}</p>
        <p><strong>Payment:</strong> {{ $order->payment_method ?? 'Manual Transfer' }}</p>
        <p><strong>Total:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>

        @php
            $orderStatusRaw = (string) ($order->order_status ?? '');
            $orderStatus = strtolower($orderStatusRaw);

            $isPacked = in_array($orderStatus, ['processing', 'shipped', 'completed'], true);
            $isInProgress = in_array($orderStatus, ['shipped', 'completed'], true);
            $isComplete = ($orderStatus === 'completed');
            $isCancelled = ($orderStatus === 'cancelled');

            $statusMap = [
                'pending' => 'Menunggu konfirmasi',
                'processing' => 'Sedang dikemas',
                'shipped' => 'Dalam pengiriman',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
            ];
            $currentStatusText = $statusMap[$orderStatus] ?? $orderStatusRaw;
        @endphp

        <div class="mt-6 rounded-xl border border-gray-100 bg-gray-50 p-4">
            <h2 class="text-lg font-semibold text-pink-700">Order Status</h2>

            <div class="mt-4 flex items-start justify-between">
                <div class="flex-1 text-center">
                    <div id="nsStatusIcon1" class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-300 text-white transition-colors">
                        <i class="fas fa-box-open text-xl"></i>
                    </div>
                    <p class="mt-2 text-sm font-medium text-gray-700">Sedang dikemas</p>
                </div>

                <div class="flex-1 px-2 pt-5">
                    <div class="ns-progress-line w-full rounded-full bg-gray-200">
                        <div id="nsProgressBarFill1" class="ns-progress-line w-0 rounded-full bg-pink-500 transition-all duration-500"></div>
                    </div>
                </div>

                <div class="flex-1 text-center">
                    <div id="nsStatusIcon2" class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-300 text-white transition-colors">
                        <i class="fas fa-truck text-xl"></i>
                    </div>
                    <p class="mt-2 text-sm font-medium text-gray-700">Dalam pengiriman</p>
                </div>

                <div class="flex-1 px-2 pt-5">
                    <div class="ns-progress-line w-full rounded-full bg-gray-200">
                        <div id="nsProgressBarFill2" class="ns-progress-line w-0 rounded-full bg-pink-500 transition-all duration-500"></div>
                    </div>
                </div>

                <div class="flex-1 text-center">
                    <div id="nsStatusIcon3" class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-300 text-white transition-colors">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <p class="mt-2 text-sm font-medium text-gray-700">Selesai</p>
                </div>
            </div>

            <p class="mt-4 text-center text-sm text-gray-600">
                Current status:
                <span class="font-semibold text-gray-900">{{ $currentStatusText }}</span>
                @if ($isCancelled)
                    <span class="ml-2 inline-flex items-center rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-700">Cancelled</span>
                @endif
            </p>
        </div>

        <div class="mt-4">
            <h2 class="text-lg font-semibold mb-2">Items</h2>
            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">Product</th>
                        <th class="border p-2">Qty</th>
                        <th class="border p-2">Price</th>
                        <th class="border p-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td class="border p-2">{{ $item->product->name ?? 'Produk dihapus' }}</td>
                        <td class="border p-2 text-center">{{ $item->quantity }}</td>
                        <td class="border p-2 text-right">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="border p-2 text-right">Rp{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Proof of Payment</h2>
            @if ($order->proof_of_payment_path)
                <img src="{{ asset('storage/' . $order->proof_of_payment_path) }}" alt="Bukti Pembayaran" class="max-h-64 object-contain border rounded" />
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $order->proof_of_payment_path) }}" target="_blank" class="text-pink-600 underline">View Full</a>
                </div>
            @else
                <p class="text-gray-500">No payment proof uploaded.</p>
            @endif
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('orders.index') }}" class="rounded bg-gray-200 px-4 py-2 text-gray-800">Back to Orders</a>
        <a href="{{ route('landing.index') }}" class="rounded bg-pink-600 px-4 py-2 text-white">Home</a>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isPacked = @json($isPacked);
            const isInProgress = @json($isInProgress);
            const isComplete = @json($isComplete);
            const isCancelled = @json($isCancelled);

            const icon1 = document.getElementById('nsStatusIcon1');
            const icon2 = document.getElementById('nsStatusIcon2');
            const icon3 = document.getElementById('nsStatusIcon3');
            const progressBarFill1 = document.getElementById('nsProgressBarFill1');
            const progressBarFill2 = document.getElementById('nsProgressBarFill2');

            if (!icon1 || !icon2 || !icon3 || !progressBarFill1 || !progressBarFill2) return;
            if (isCancelled) return;

            const activate = (icon, fill) => {
                icon.classList.remove('bg-gray-300');
                icon.classList.add('bg-pink-500');
                if (fill) {
                    fill.classList.remove('w-0');
                    fill.classList.add('w-full');
                }
            };

            setTimeout(() => {
                if (isPacked) activate(icon1, progressBarFill1);
            }, 100);

            setTimeout(() => {
                if (isInProgress) activate(icon2, progressBarFill2);
            }, 600);

            setTimeout(() => {
                if (isComplete) {
                    activate(icon3, null);
                    progressBarFill2.classList.remove('bg-pink-500');
                    progressBarFill2.classList.add('bg-emerald-500');
                }
            }, 1100);
        });
    </script>
@endpush
