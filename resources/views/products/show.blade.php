@extends('layouts.app')

@section('title', $product->name . ' | Nail Studio')

@section('body-class', 'gradient-bg min-h-screen')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endpush

@section('content')
    <main class="mx-auto max-w-6xl px-4 pt-16 pb-24">
        <nav class="flex items-center text-sm text-gray-500">
            <a href="{{ route('landing.index') }}" class="hover:text-pink-500">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-pink-500">Produk</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $product->name }}</span>
        </nav>

        @if (session('success'))
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('quantity'))
            <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-6 py-4 text-sm text-rose-700">
                {{ $errors->first('quantity') }}
            </div>
        @endif

        <section class="mt-10 grid gap-8 lg:grid-cols-12">
            <div class="overflow-hidden rounded-3xl bg-white shadow-lg shadow-pink-100 lg:col-span-4">
                <div class="flex items-center justify-center bg-white" style="aspect-ratio: 1 / 1;">
                    <img src="{{ $product->image_url ?? $fallbackImage }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                </div>
            </div>

            <div class="flex flex-col gap-6 lg:col-span-5">
                <div class="space-y-4">
                    <p class="text-sm font-semibold uppercase tracking-widest text-pink-500">{{ $product->category_label ?? 'Nail Art' }}</p>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                </div>

                <div class="flex items-center gap-3">
                    @if ($product->discount > 0)
                        <span class="text-3xl font-bold text-pink-500">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                        <span class="text-lg font-semibold text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="rounded-full bg-pink-50 px-3 py-1 text-xs font-semibold text-pink-500">Diskon {{ $product->discount }}%</span>
                    @else
                        <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                    @endif
                </div>

                <div class="text-base leading-relaxed text-gray-600">
                    {{ $product->description ?? 'Detail produk belum tersedia. Hubungi kami untuk informasi lebih lanjut mengenai desain dan layanan nail art ini.' }}
                </div>
            </div>

            <aside class="flex flex-col gap-6 rounded-3xl bg-white p-8 shadow-lg shadow-pink-100 lg:col-span-3">
                @if ($product->exists)
                    <form method="POST" action="{{ route('cart.items.store') }}" class="flex flex-col gap-6" data-quantity-form>
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="space-y-2 text-sm text-gray-600">
                            <span class="text-sm font-semibold text-gray-500">Atur jumlah</span>
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2 rounded-full border border-gray-200 px-3 py-1.5">
                                    <button type="button" data-action="decrement" class="inline-flex h-7 w-7 items-center justify-center text-base font-semibold text-gray-500 transition hover:text-pink-500">-</button>
                                    <input
                                        type="number"
                                        name="quantity"
                                        data-quantity-input
                                        class="h-7 w-11 border-0 bg-transparent text-center text-sm font-semibold text-gray-800 focus:outline-none"
                                        value="{{ old('quantity', $product->minimum_quantity) }}"
                                        min="{{ $product->minimum_quantity }}"
                                        @if($product->is_in_stock)
                                            max="{{ $product->stock_quantity }}"
                                        @endif
                                        data-min="{{ $product->minimum_quantity }}"
                                        data-max="{{ $product->stock_quantity }}"
                                    >
                                    <button type="button" data-action="increment" class="inline-flex h-7 w-7 items-center justify-center text-base font-semibold text-gray-500 transition hover:text-pink-500">+</button>
                                </div>
                                <span class="pr-1 text-sm text-gray-600">Stok: <span class="font-semibold text-gray-900">{{ $product->stock_quantity }}</span></span>
                            </div>
                            <p class="text-xs text-gray-400">Minimal pembelian {{ $product->minimum_quantity }} item.</p>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>Subtotal</span>
                                <div class="text-right">
                                    <div class="text-xl font-bold leading-tight text-pink-500" data-subtotal data-unit-price="{{ $product->final_price }}">
                                        Rp {{ number_format($product->final_price, 0, ',', '.') }}
                                    </div>
                                    @if ($product->discount > 0)
                                        <div class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @auth
                            <button
                                type="submit"
                                class="flex w-full items-center justify-center rounded-xl bg-pink-500 px-6 py-3 text-xs font-semibold text-white shadow transition hover:bg-pink-600 whitespace-nowrap disabled:cursor-not-allowed disabled:bg-gray-300"
                                {{ $product->is_in_stock ? '' : 'disabled' }}
                            >
                                {{ $product->is_in_stock ? 'Tambahkan ke Keranjang' : 'Stok Habis' }}
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="flex w-full items-center justify-center rounded-xl bg-gray-800 px-6 py-3 text-xs font-semibold text-white shadow transition hover:bg-gray-900">
                                Masuk untuk membeli
                            </a>
                        @endauth
                    </form>
                @else
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-800">
                        Produk ini merupakan contoh dan belum tersedia. Silakan pilih produk lain dari katalog kami.
                    </div>
                @endif

                <div class="flex items-center justify-center text-xs font-medium text-pink-500">
                    <div class="flex items-center gap-0">
                        <button type="button" class="inline-flex items-center gap-1 px-2 py-1 transition hover:text-pink-600">
                            <span>♡</span>
                            <span>Wishlist</span>
                        </button>
                        <span class="text-pink-200">|</span>
                        <button type="button" class="inline-flex items-center gap-1 px-2 py-1 transition hover:text-pink-600">
                            <span>⇪</span>
                            <span>Bagikan</span>
                        </button>
                        <span class="text-pink-200">|</span>
                        <button type="button" class="inline-flex items-center gap-1 px-2 py-1 transition hover:text-pink-600">
                            <span>!</span>
                            <span>Laporkan</span>
                        </button>
                    </div>
                </div>
            </aside>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        document.querySelectorAll('[data-quantity-form]').forEach(function (form) {
            const input = form.querySelector('[data-quantity-input]');
            const subtotal = form.querySelector('[data-subtotal]');
            const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

            const clampValue = (value) => {
                const min = parseInt(input.dataset.min ?? '1', 10) || 1;
                const max = parseInt(input.dataset.max ?? value, 10) || value;
                return Math.min(Math.max(value, min), Math.max(min, max));
            };

            const updateSubtotal = () => {
                if (!subtotal) return;
                const unitPrice = parseFloat(subtotal.dataset.unitPrice ?? '0');
                const quantity = parseInt(input.value || '1', 10);
                subtotal.textContent = formatter.format(unitPrice * quantity);
            };

            form.querySelectorAll('[data-action]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const current = parseInt(input.value || '1', 10);
                    const next = button.dataset.action === 'increment' ? current + 1 : current - 1;
                    input.value = clampValue(next);
                    updateSubtotal();
                });
            });

            input.addEventListener('input', function () {
                const parsed = parseInt(input.value || '1', 10);
                if (Number.isNaN(parsed)) {
                    input.value = input.dataset.min || 1;
                } else {
                    input.value = clampValue(parsed);
                }
                updateSubtotal();
            });

            updateSubtotal();
        });
    </script>
@endpush
