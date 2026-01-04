@extends('layouts.app')

@section('title', 'Proof of Payment | Nail Studio')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <nav class="text-sm text-gray-500 mb-2">
                <a href="{{ route('orders.index') }}" class="hover:text-pink-600">My Orders</a> /
                <a href="{{ route('orders.show', $order->id) }}" class="hover:text-pink-600">Order #{{ $order->order_number }}</a> /
                <span class="text-gray-900 font-medium">Proof of Payment</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Proof of Payment</h1>
            <p class="text-gray-500 text-sm">Order #{{ $order->order_number }}</p>
        </div>

        <a href="{{ route('orders.show', $order->id) }}"
           class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold">
            Back to Order
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Photo</h2>
                <a href="{{ route('orders.proof.image', $order->id) }}" target="_blank" class="text-sm font-bold text-pink-600 hover:text-pink-700">
                    Open Image
                </a>
            </div>
            <div class="p-6">
                <div class="rounded-xl overflow-hidden border bg-gray-50">
                    <img src="{{ route('orders.proof.image', $order->id) }}" class="w-full max-h-[70vh] object-contain" alt="Proof of payment">
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Details</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Customer</span>
                        <span class="font-bold text-gray-900">{{ $order->user->name ?? 'Customer' }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Order Date</span>
                        <span class="font-medium text-gray-900">{{ $order->created_at?->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Uploaded/Modified</span>
                        <span class="font-medium text-gray-900">{{ $metadata['last_modified']->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">File</span>
                        <span class="font-medium text-gray-900">{{ $metadata['file_name'] }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Type</span>
                        <span class="font-medium text-gray-900">{{ $metadata['mime_type'] }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Size</span>
                        <span class="font-medium text-gray-900">{{ number_format($metadata['size_bytes'] / 1024, 1) }} KB</span>
                    </div>
                    @if(!empty($metadata['width']) && !empty($metadata['height']))
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500">Dimensions</span>
                            <span class="font-medium text-gray-900">{{ $metadata['width'] }}×{{ $metadata['height'] }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Payment</h2>
                <div class="flex justify-between gap-4 text-sm">
                    <span class="text-gray-500">Method</span>
                    <span class="font-medium text-gray-900">{{ $order->payment_method ?? 'Manual Transfer' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
