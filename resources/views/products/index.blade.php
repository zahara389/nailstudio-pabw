@extends('layouts.app')

@section('title', 'Katalog Produk Nail Art')

@section('body-class', 'gradient-bg min-h-screen')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endpush

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16">
        <div class="mb-12 text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-pink-500">Katalog Nail Art</p>
            <h1 class="mt-3 text-3xl font-bold text-gray-900 md:text-4xl">Temukan Gaya Nail Art Favoritmu</h1>
            <p class="mt-4 text-base text-gray-600 md:text-lg">Pilih dari koleksi eksklusif kami yang dirancang untuk berbagai gaya dan kebutuhan perawatan kuku.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($products as $product)
                <a
                    href="{{ route('products.show', ['category' => $product->category_slug, 'product' => $product->slug]) }}?id={{ $product->id ?? 0 }}"
                    class="relative product-card group flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md shadow-pink-100 transition-transform duration-200 focus:outline-none"
                    data-card
                >
                    <div class="relative h-48 w-full overflow-hidden">
                        <img
                            src="{{ $product->image_url }}"
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            onerror="this.src='{{ $fallbackImage }}';"
                        >
                        <span class="absolute right-4 top-4 inline-flex items-center rounded-full bg-pink-500 px-3 py-1 text-xs font-semibold text-white shadow">#{{ $product->card_number }}</span>
                    </div>

                    <div class="flex flex-1 flex-col gap-4 p-5">
                        <div class="flex items-center justify-between text-xs font-medium uppercase tracking-wide text-gray-400">
                            <span class="truncate text-gray-500">{{ $product->category_label ?? 'Nail Art' }}</span>
                            @if ($product->discount > 0)
                                <span class="rounded-full bg-pink-50 px-3 py-1 text-pink-500">Diskon {{ $product->discount }}%</span>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h2>
                            <div class="mt-2 flex items-baseline gap-3">
                                @if ($product->discount > 0)
                                    <p class="text-xl font-bold text-pink-500">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</p>
                                    <p class="text-sm font-medium text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                @else
                                    <p class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full flex flex-col items-center rounded-3xl bg-white/80 p-12 shadow-lg shadow-pink-100">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-pink-100 text-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5c3.59 0 6.5-2.91 6.5-6.5S15.59 6.5 12 6.5 5.5 9.41 5.5 13s2.91 6.5 6.5 6.5zm0 0v-5m0 0H8.75M12 14.5h3.25M12 2.25v2.25" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Produk belum tersedia</h3>
                    <p class="mt-3 text-center text-sm text-gray-600">Kami sedang menyiapkan koleksi terbaik kami. Silakan kembali lagi nanti untuk melihat update terbaru.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('[data-card]');

            cards.forEach((card) => {
                card.addEventListener('mouseenter', () => {
                    card.classList.add('product-card--active');
                });

                card.addEventListener('mouseleave', () => {
                    card.classList.remove('product-card--active');
                });
            });
        });
    </script>
@endpush
