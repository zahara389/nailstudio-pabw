@extends('layouts.app')

@section('title', 'My Orders | Nail Studio')

@section('content')
<div class="max-w-4xl mx-auto pt-16 pb-20 px-4">
    <h1 class="text-2xl font-bold mb-6 text-pink-700">Order History</h1>

    @if ($orders->isEmpty())
        <p class="text-gray-500">You have no orders yet.</p>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-4 transition hover:shadow-lg">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Order: <strong>{{ $order->order_number }}</strong></p>
                            <p class="text-lg text-gray-800 font-semibold">
                                Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Date: {{ $order->created_at->format('d M Y, H:i') }} | Status: {{ $order->order_status }}
                            </p>
                        </div>
                        <a href="{{ route('orders.show', $order->id) }}"
                           class="bg-pink-500 text-white text-sm font-bold py-2 px-4 rounded-full hover:bg-pink-600 transition-colors flex-shrink-0">
                            Details
                        </a>
                    </div>
                    <div class="border-t pt-3">
                        <p class="text-xs text-gray-500">
                            Items:
                            <span class="text-gray-700">
                                {{ $order->items->map(fn($i) => $i->product->name . ' x' . $i->quantity)->implode(', ') }}
                            </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
