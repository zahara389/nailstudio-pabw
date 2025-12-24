@extends('layouts.app')

@section('title', 'Order Detail | Nail Studio')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-4 text-pink-700">Order Detail {{ $order->order_number }}</h1>

    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Status:</strong> {{ $order->order_status }}</p>
        <p><strong>Payment:</strong> {{ $order->payment_method ?? 'Manual Transfer' }}</p>
        <p><strong>Total:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>

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
