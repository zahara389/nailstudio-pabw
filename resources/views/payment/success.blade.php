@extends('layouts.app')

@section('title', 'Payment Successful | Nail Studio')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="bg-white max-w-md w-full rounded-xl shadow-lg p-8 text-center">
        <div class="mb-4">
            <svg class="success-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" style="width:72px;height:72px;display:block;margin:0 auto;">
                <circle cx="26" cy="26" r="25" fill="none" stroke="#10b981" stroke-width="3" />
                <path fill="none" stroke="#10b981" stroke-width="3" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Payment Successful!</h1>
        <p class="text-gray-600 mb-6">Thank you for your payment. Your order is now being processed.</p>

        <div class="mt-8 space-y-3">
            <a href="{{ route('landing.index') }}" class="block w-full text-center bg-pink-600 text-white font-semibold py-3 rounded-lg hover:bg-pink-700 transition-transform transform hover:scale-105">
                Back to Homepage
            </a>
            <a href="{{ route('orders.index') }}" class="block w-full text-center bg-gray-100 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-200 transition-transform transform hover:scale-105">
                View My Orders
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.success-checkmark__circle{stroke-dasharray:166;stroke-dashoffset:166;stroke-width:2;stroke-miterlimit:10;stroke:#10b981;fill:none;animation:stroke 0.6s cubic-bezier(0.65,0,0.45,1) forwards}
.success-checkmark__check{transform-origin:50% 50%;stroke:#10b981;stroke-width:2;stroke-linecap:round;stroke-dasharray:48;stroke-dashoffset:48;animation:stroke 0.3s cubic-bezier(0.65,0,0.45,1) 0.6s forwards}
@keyframes stroke{100%{stroke-dashoffset:0}}
</style>
@endpush
