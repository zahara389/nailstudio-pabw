@extends('layouts.app-admin')

@section('content')
<div class="head-title">
    <div class="left">
        <h1>Edit Product</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('product.index') }}">Product</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Edit</a></li>
        </ul>
    </div>
</div>

<div class="product-form-container">
    <h2>Edit Produk ID: {{ $id }}</h2>
    
    {{-- Form mengarah ke route product.update (POST dengan method PUT/PATCH) --}}
    <form action="{{ url('product/' . $id) }}" method="POST" enctype="multipart/form-data" class="form-style">
        @csrf
        @method('PUT') {{-- PENTING: Untuk simulasi update di Laravel --}}

        <div class="alert alert-warning">
            INFO: Ini adalah halaman edit simulasi. Data asli produk ID **{{ $id }}** seharusnya dimuat dari database di sini.
        </div>
        
        <div class="form-group">
            <label for="namaproduct">Nama Produk</label>
            <input type="text" name="namaproduct" id="namaproduct" value="Nama Produk {{ $id }}" required>
        </div>
        
        {{-- ... tambahkan input form lainnya dengan value yang dimuat dari DB ... --}}
        
        <button type="submit" class="btn-submit">Update Produk</button>
    </form>
</div>
@endsection

@section('styles')
{{-- Gunakan CSS yang sama dari View Create (atau pindahkan ke style2.css) --}}
<style>
/* ... Salin style dari form Add Product di atas ... */
.product-form-container { max-width: 600px; margin: 30px auto; padding: 25px; background: #fff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; }
.form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
.btn-submit { background-color: #8B1D3B; color: white; padding: 12px 20px; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; transition: background-color 0.3s; }
.btn-submit:hover { background-color: #6a162d; }
</style>
@endsection