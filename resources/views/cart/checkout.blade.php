@extends('layouts.app')

@section('title', 'Checkout | Nail Studio')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6 text-pink-700">Checkout</h1>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg border border-green-200 bg-green-50 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('alert'))
        <div class="mb-6 p-4 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-800">
            {{ session('alert') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg border border-red-200 bg-red-50 text-red-700">
            <p class="font-semibold mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Order Details Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Order Details</h2>
        
        @if($items->isEmpty())
            <div class="text-center py-8 text-gray-500">Keranjang Anda kosong.</div>
        @else
            <ul class="divide-y divide-gray-200 mb-4">
                @foreach($items as $item)
                    @php
                        $product = $item->product;
                        $originalPrice = $item->unit_price;
                        $discount = $product?->discount ?? 0;
                        $priceAfterDiscount = $originalPrice * (1 - $discount / 100);
                        $itemTotal = $item->quantity * $priceAfterDiscount;
                    @endphp
                    <li class="py-2 flex justify-between items-center">
                        <span class="text-gray-700">
                            {{ $product->name ?? 'Produk' }}
                            <span class="text-xs text-gray-500">x{{ $item->quantity }}</span>
                        </span>
                        <span class="font-medium text-gray-800">
                            @if($discount > 0)
                                <span class="line-through text-gray-400 text-sm">
                                    Rp{{ number_format($originalPrice, 0, ',', '.') }}
                                </span>
                                <span class="font-semibold text-gray-800">
                                    Rp{{ number_format($priceAfterDiscount, 0, ',', '.') }}
                                </span>
                            @else
                                Rp{{ number_format($originalPrice, 0, ',', '.') }}
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
            
            <div class="flex justify-between items-center border-t pt-4">
                <span class="font-semibold text-gray-900">Total</span>
                <span class="font-semibold text-pink-700 text-lg">
                    Rp{{ number_format($subtotal, 0, ',', '.') }}
                </span>
            </div>
        @endif
    </div>

    <!-- Payment Method Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Select payment options</h2>
            <span class="text-sm text-gray-500">Pembayaran dienkripsi 🔒</span>
        </div>
        <form id="payment-method-form" method="POST" onsubmit="return handlePaymentSubmit();">
            @csrf
            <div class="space-y-4">
                <!-- Debit / Credit Card (Disabled) -->
                <label class="flex items-center gap-3 cursor-not-allowed opacity-50">
                    <input type="radio" name="payment_method" value="debit" disabled class="accent-pink-500" />
                    <span class="text-gray-700 font-medium">Debit / Credit Card</span>
                    <span class="ml-2 text-xs bg-gray-200 text-gray-500 px-2 py-1 rounded">Coming Soon</span>
                </label>
                
                <!-- QRIS -->
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="payment_method" value="qris" checked class="accent-pink-500" />
                    <span class="text-gray-700 font-medium">QRIS (E-wallet & Bank)</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/QRIS_logo.svg" alt="QRIS Logo" class="w-20 h-20 object-contain" />
                </label>
            </div>
        </form>
    </div>

    <!-- Shipping Address Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8" x-data="{ showModal: false }">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Shipping Address</h2>
            <button type="button" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-1 rounded text-sm font-semibold" @click="showModal = true">
                Add New Address
            </button>
        </div>
        
        @if($user->addresses()->where('type', 'shipping')->exists())
            <form id="address-form">
                <div class="space-y-3">
                    @foreach($user->addresses()->where('type', 'shipping')->get() as $address)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="selected_address" value="{{ $address->id }}" 
                                @if($loop->first) checked @endif class="accent-pink-500" />
                            <span class="text-gray-700">{{ $address->address }}</span>
                        </label>
                    @endforeach
                </div>
            </form>
        @else
            <div class="text-gray-500 mb-2">You don't have a saved address yet.</div>
        @endif

        <!-- Modal Add New Address -->
        <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-black bg-opacity-40" @click="showModal = false"></div>
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md z-10">
                <h3 class="text-lg font-semibold mb-4">Add New Address</h3>
                <form method="POST" action="{{ route('address.store') }}" class="space-y-4">
                    @csrf
                    <textarea name="address" rows="3" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-pink-500 focus:border-pink-500" placeholder="Enter your shipping address..."></textarea>
                    <input type="hidden" name="type" value="shipping">
                    <div class="flex justify-end gap-2">
                        <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium" @click="showModal = false">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-pink-600 text-white hover:bg-pink-700 font-medium">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- QRIS Modal -->
    <div id="qrisModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 px-2" style="display:none;">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
            <div class="flex items-center gap-3 mb-6">
                <h2 class="text-lg font-semibold">Bayar dengan</h2>
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/QRIS_logo.svg" alt="QRIS Logo" class="w-24 h-24 object-contain" />
            </div>
            
            <div class="flex flex-col md:flex-row items-center gap-8 mb-6">
                <!-- QRIS Code Image -->
                <div class="flex-shrink-0 bg-gray-100 border-2 border-gray-300 rounded-lg p-4">
                    @if(file_exists(public_path('images/qris-code.jpg')))
                        <img src="{{ asset('images/qris-code.jpg') }}" alt="QRIS Code" class="w-56 h-56 object-cover" />
                    @else
                        <div class="w-56 h-56 bg-gray-200 flex items-center justify-center rounded text-center">
                            <div class="text-gray-600 p-4">
                                <p class="font-semibold mb-2">QRIS Code Placeholder</p>
                                <p class="text-sm">Replace with actual QRIS code image</p>
                                <p class="text-xs mt-2">File: public/images/qris-code.jpg</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Payment Instructions -->
                <div class="flex-1">
                    <p class="mb-4 text-gray-700 leading-relaxed">
                        Scan kode QRIS di samping menggunakan aplikasi e-wallet atau mobile banking Anda:
                    </p>
                    <ul class="text-sm text-gray-600 mb-6 space-y-2">
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                            GoPay
                        </li>
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                            OVO
                        </li>
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                            DANA
                        </li>
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                            ShopeePay & Bank Lokal
                        </li>
                    </ul>
                    
                    <!-- Total Amount -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-600 mb-1">Nominal yang harus dibayar:</p>
                        <p class="font-extrabold text-green-700 text-3xl font-mono">
                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    <div class="inline-block bg-pink-100 text-pink-700 px-3 py-1 rounded text-xs font-semibold">
                        ✓ QRIS Aktif 24 Jam
                    </div>
                </div>
            </div>

            <!-- Upload Proof of Payment Form -->
            <form method="POST" enctype="multipart/form-data" action="{{ route('cart.checkout.qris') }}" class="space-y-4 border-t pt-6" id="buktiForm" onsubmit="return validateQrisForm();">
                @csrf
                <input type="hidden" name="selected_address" id="selectedAddress" value="">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Payment Receipt (Bukti Bayar)</label>
                    <input type="file" name="bukti_bayar" accept="image/png,image/jpeg" required
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 transition-colors duration-150 cursor-pointer border border-gray-300 rounded px-3 py-2"
                        id="buktiInput"
                    />
                    <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG (Max 5MB)</p>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="hideQrisModal()" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium">
                        Cancel
                    </button>
                    <button type="submit" id="buktiSubmitBtn" class="px-6 py-2 rounded bg-pink-600 text-white font-semibold hover:bg-pink-700 transition" disabled>
                        Complete Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bottom Actions -->
    <div class="flex justify-between items-center mt-8 gap-4">
        <a href="{{ route('cart.index') }}" class="px-5 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium">
            ← Back to Cart
        </a>
        <button type="submit" form="payment-method-form" class="px-6 py-2 rounded bg-pink-600 text-white font-semibold hover:bg-pink-700 transition">
            Next →
        </button>
    </div>
</div>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>

<script>
function handlePaymentSubmit() {
    const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
    if (selectedPayment === 'qris') {
        // Get selected address
        const selectedAddress = document.querySelector('input[name="selected_address"]:checked');
        
        if (!selectedAddress) {
            alert('Silakan pilih alamat pengiriman terlebih dahulu!');
            return false;
        }

        // Set hidden input value
        document.getElementById('selectedAddress').value = selectedAddress.value;
        
        showQrisModal();
        return false;
    }
    return true;
}

function validateQrisForm() {
    const selectedAddressValue = document.getElementById('selectedAddress').value;
    const fileInput = document.getElementById('buktiInput');

    if (!selectedAddressValue) {
        alert('Silakan pilih alamat pengiriman terlebih dahulu!');
        return false;
    }

    if (!fileInput || !fileInput.files || !fileInput.files.length) {
        alert('Silakan upload bukti bayar terlebih dahulu!');
        return false;
    }

    return true;
}

function showQrisModal() {
    document.getElementById('qrisModal').style.display = 'flex';
}

function hideQrisModal() {
    document.getElementById('qrisModal').style.display = 'none';
    document.getElementById('buktiInput').value = '';
    document.getElementById('buktiSubmitBtn').disabled = true;
}

// Enable submit button when file is selected
document.getElementById('buktiInput').addEventListener('change', function() {
    document.getElementById('buktiSubmitBtn').disabled = !this.files.length;
});
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
