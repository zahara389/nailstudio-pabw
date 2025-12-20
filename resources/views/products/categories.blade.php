@extends('layouts.app')

@section('title', 'Katalog Produk | Nail Studio')

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
            <h1 class="mt-3 text-3xl font-bold text-gray-900 md:text-4xl">Pilih Kategori Produk</h1>
            <p class="mt-4 text-base text-gray-600 md:text-lg">Lihat koleksi per kategori supaya lebih rapi dan mudah dicari.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (($categories ?? []) as $category)
                <a
                    href="{{ route('products.index', ['category' => $category['slug']]) }}"
                    class="relative overflow-hidden rounded-2xl bg-white shadow-md shadow-pink-100 transition-transform duration-200 hover:scale-[1.01]"
                >
                    <div class="p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-pink-500">Kategori</p>
                        <h2 class="mt-2 text-lg font-semibold text-gray-900">{{ $category['label'] }}</h2>
                        <p class="mt-2 text-sm text-gray-600">{{ $category['subtitle'] }}</p>
                        <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-pink-50 px-4 py-2 text-xs font-semibold text-pink-600">
                            Lihat produk
                            <span aria-hidden="true">→</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
