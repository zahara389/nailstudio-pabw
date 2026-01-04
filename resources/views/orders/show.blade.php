@extends('layouts.app')

@section('title', 'Order Detail | Nail Studio')

@push('styles')
    <style>
        .step-icon { transition: all 0.3s ease; }
    </style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto py-12 px-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <nav class="text-sm text-gray-500 mb-2">
                <a href="{{ route('orders.index') }}" class="hover:text-pink-600">My Orders</a> / 
                <span class="text-gray-900 font-medium">Detail</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
            <p class="text-gray-500 text-sm">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        
        @php
            $orderStatusRaw = strtolower($order->order_status ?? '');
            $statusColors = [
                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                'cancelled' => 'bg-rose-100 text-rose-700 border-rose-200',
            ];
            $statusColor = $statusColors[$orderStatusRaw] ?? 'bg-gray-100 text-gray-700 border-gray-200';
        @endphp
        
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border {{ $statusColor }}">
            <span class="w-2 h-2 mr-2 rounded-full bg-current"></span>
            {{ ucfirst($orderStatusRaw) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-8">Order Journey</h2>
                
                <div class="relative flex items-center justify-between">
                    <div class="absolute left-6 right-6 top-6 h-1 bg-gray-100 -z-0"></div>
                    
                    <div class="absolute left-6 top-6 h-1 bg-pink-500 transition-all duration-700 -z-0" 
                         id="mainProgressBar" style="width: 0%"></div>

                    @php
                        $steps = [
                            ['id' => 'processing', 'label' => 'Packed', 'icon' => 'fa-box-open'],
                            ['id' => 'shipped', 'label' => 'Shipped', 'icon' => 'fa-truck'],
                            ['id' => 'completed', 'label' => 'Arrived', 'icon' => 'fa-check-circle']
                        ];
                    @endphp

                    @foreach($steps as $index => $step)
                    <div class="relative z-10 flex flex-col items-center group">
                        <div id="step-icon-{{ $index + 1 }}" 
                             data-icon="{{ $step['icon'] }}"
                             class="step-icon w-12 h-12 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center text-gray-400 group-hover:border-pink-300">
                            <i class="fas {{ $step['icon'] }} text-lg"></i>
                        </div>
                        <span class="mt-3 text-xs font-bold uppercase tracking-wider text-gray-500">{{ $step['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900">Purchased Items</h2>
                    <span class="text-sm text-gray-500">{{ $order->items->count() }} Items</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                    <div class="p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                        <div class="w-20 h-20 rounded-xl bg-gray-100 flex-shrink-0 overflow-hidden border">
                            @php
                                $productImagePath = $item->product->image ?? null;
                                $productImageUrl = $productImagePath
                                    ? (filter_var($productImagePath, FILTER_VALIDATE_URL) ? $productImagePath : asset($productImagePath))
                                    : null;
                            @endphp

                            @if($productImageUrl)
                                <img src="{{ $productImageUrl }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-gray-900">{{ $item->product->name ?? 'Deleted Product' }}</h3>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × Rp{{ number_format($item->unit_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right font-bold text-gray-900">
                            Rp{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-gray-50 p-6 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-black text-pink-700 pt-2 border-t">
                        <span>Total Amount</span>
                        <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Payment Info</h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Method</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->payment_method ?? 'Manual Transfer' }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t">
                        <p class="text-xs text-gray-500 uppercase font-bold mb-3">Proof of Payment</p>
                        @if ($order->proof_of_payment_path)
                            <div class="relative group cursor-pointer overflow-hidden rounded-xl border">
                                <img src="{{ route('orders.proof.image', $order->id) }}" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500" />
                                <a href="{{ route('orders.proof.show', $order->id) }}" 
                                   class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white font-medium transition-opacity">
                                    Click to View Details
                                </a>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-xl p-4 text-center border-2 border-dashed">
                                <p class="text-sm text-gray-400 italic">No proof uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ route('landing.index') }}" class="w-full py-4 bg-pink-600 hover:bg-pink-700 text-white rounded-2xl font-bold text-center shadow-lg shadow-pink-200 transition-all active:scale-95">
                    Continue Shopping
                </a>
                <a href="{{ route('orders.index') }}" class="w-full py-4 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-2xl font-bold text-center transition-all">
                    Back to My Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isPacked = @json($isPacked ?? false);
            const isInProgress = @json($isInProgress ?? false);
            const isComplete = @json($isComplete ?? false);
            const isCancelled = @json($isCancelled ?? false);

            const progressBar = document.getElementById('mainProgressBar');
            const icons = [
                document.getElementById('step-icon-1'),
                document.getElementById('step-icon-2'),
                document.getElementById('step-icon-3')
            ];

            const clamp = (num, min, max) => Math.min(Math.max(num, min), max);

            const setStepState = (index, state) => {
                const el = icons[index];
                if (!el) return;

                const i = el.querySelector('i');
                const original = el.getAttribute('data-icon') || 'fa-circle';

                // reset
                el.classList.remove(
                    'bg-pink-600', 'border-pink-600', 'text-white', 'ring-4', 'ring-pink-100',
                    'bg-emerald-600', 'border-emerald-600', 'ring-emerald-100',
                    'bg-white', 'text-gray-400', 'border-gray-200', 'text-pink-600', 'text-emerald-600'
                );

                if (state === 'pending') {
                    el.classList.add('bg-white', 'border-gray-200', 'text-gray-400');
                    if (i) i.className = `fas ${original} text-lg`;
                    return;
                }

                if (state === 'active') {
                    el.classList.add('bg-white', 'border-pink-600', 'text-pink-600', 'ring-4', 'ring-pink-100');
                    if (i) i.className = `fas ${original} text-lg`;
                    return;
                }

                if (state === 'completed') {
                    el.classList.add('bg-pink-600', 'border-pink-600', 'text-white');
                    if (i) i.className = 'fas fa-check text-lg';
                    return;
                }

                if (state === 'completedFinal') {
                    el.classList.add('bg-emerald-600', 'border-emerald-600', 'text-white', 'ring-4', 'ring-emerald-100');
                    if (i) i.className = 'fas fa-check text-lg';
                }
            };

            const setProgress = (percent) => {
                // Because the bar starts at left-6 and should stop at right-6,
                // we can map 0-100% within that bounded track.
                progressBar.style.width = `${clamp(percent, 0, 100)}%`;
            };

            if (isCancelled) return;

            setTimeout(() => {
                // default
                setProgress(0);
                setStepState(0, 'pending');
                setStepState(1, 'pending');
                setStepState(2, 'pending');

                if (isPacked) {
                    setProgress(0);
                    setStepState(0, 'active');
                }

                if (isInProgress) {
                    setProgress(50);
                    setStepState(0, 'completed');
                    setStepState(1, 'active');
                }

                if (isComplete) {
                    setProgress(100);
                    progressBar.classList.replace('bg-pink-500', 'bg-emerald-500');
                    setStepState(0, 'completed');
                    setStepState(1, 'completed');
                    setStepState(2, 'completedFinal');
                }
            }, 300);
        });
    </script>
@endpush