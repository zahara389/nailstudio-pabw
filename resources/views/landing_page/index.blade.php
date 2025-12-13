{{-- 1. Menggunakan @extends untuk mewarisi layouts/app.blade.php --}}
@extends('layouts.app')

{{-- 2. Mengisi slot 'title' di layouts/app.blade.php --}}
@section('title', 'Home - Premium Nail Art Studio')

{{-- 3. Masukkan semua konten spesifik halaman ke dalam section 'content' --}}
@section('content')

    @include('landing_page.hero')

    @include('landing_page.top-products')

    @include('landing_page.categories')

    @include('landing_page.see-more-products')

    @include('landing_page.booking')

    @include('landing_page.team')

    @include('landing_page.lowongan-pekerjaan')

@endsection

{{-- Script umum sudah dimuat melalui layouts/app.blade.php --}}