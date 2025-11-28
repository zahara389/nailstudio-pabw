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
    <h2>Edit Produk: {{ $product->name }}</h2>
    
    {{-- Form mengarah ke route product.update --}}
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form-style">
        @csrf
        @method('PUT')

        {{-- Menampilkan pesan error validasi --}}
        @if ($errors->any())
            <div class="alert-danger">
                <strong>Terjadi Kesalahan Validasi:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="form-group">
            <label for="namaproduct">Nama Produk <span class="required">*</span></label>
            <input type="text" name="namaproduct" id="namaproduct" value="{{ old('namaproduct', $product->name) }}" placeholder="Contoh: PINK PERFECTION" required>
            @error('namaproduct') <div class="text-error">{{ $message }}</div> @enderror 
        </div>
        
        <div class="form-group">
            <label for="category">Kategori <span class="required">*</span></label>
            <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" placeholder="Contoh: nail kit" required>
            @error('category') <div class="text-error">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="stock">Stock <span class="required">*</span></label>
            <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $product->stock) }}" placeholder="Contoh: 10" required>
            @error('stock') <div class="text-error">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Harga (Rp) <span class="required">*</span></label>
            <input type="number" name="price" id="price" min="0" value="{{ old('price', $product->price) }}" placeholder="Contoh: 50000" required>
            @error('price') <div class="text-error">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="discount">Diskon (%)</label>
            <input type="number" name="discount" id="discount" min="0" max="100" value="{{ old('discount', $product->discount) }}" placeholder="Contoh: 10">
            <small class="help-text">Opsional - Kosongkan jika tidak ada diskon</small>
            @error('discount') <div class="text-error">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="status">Status Produk</label>
            <select name="status" id="status">
                <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                <option value="low stock" {{ old('status', $product->status) == 'low stock' ? 'selected' : '' }}>Low Stock</option>
                <option value="out of stock" {{ old('status', $product->status) == 'out of stock' ? 'selected' : '' }}>Out of Stock</option>
            </select>
            @error('status') <div class="text-error">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="image">Gambar Produk</label>
            
            @if($product->image)
                <div class="current-image">
                    <p><strong>Gambar Saat Ini:</strong></p>
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 200px; height: auto; border-radius: 8px; margin-bottom: 10px;">
                </div>
            @endif
            
            <input type="file" name="image" id="image" accept="image/*">
            <small class="help-text">Format: JPG, PNG, GIF (Max 2MB) - Biarkan kosong jika tidak ingin mengubah gambar</small>
            @error('image') <div class="text-error">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-actions">
            <a href="{{ route('product.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Update Produk</button>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
/* Container Form */
.product-form-container { 
    max-width: 700px; 
    margin: 30px auto; 
    padding: 30px; 
    background: #fff; 
    border-radius: 10px; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
}

.product-form-container h2 {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #8B1D3B;
}

/* Current Image Preview */
.current-image {
    margin-bottom: 15px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.current-image p {
    margin: 0 0 10px 0;
    font-weight: 600;
    color: #555;
}

/* Form Group */
.form-group { 
    margin-bottom: 20px; 
}

.form-group label { 
    display: block; 
    margin-bottom: 8px; 
    font-weight: 600; 
    color: #555;
    font-size: 14px;
}

.form-group label .required {
    color: #dc3545;
    margin-left: 2px;
}

/* Input Styles */
.form-group input[type="text"], 
.form-group input[type="number"], 
.form-group input[type="file"],
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 14px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-group input[type="text"]:focus, 
.form-group input[type="number"]:focus,
.form-group select:focus {
    outline: none;
    border-color: #8B1D3B;
    box-shadow: 0 0 0 3px rgba(139, 29, 59, 0.1);
}

.form-group select {
    background-color: white;
    cursor: pointer;
}

.form-group input[type="file"] {
    padding: 10px;
    cursor: pointer;
}

/* Help Text */
.help-text {
    display: block;
    font-size: 12px;
    color: #888;
    margin-top: 5px;
}

/* Error Messages */
.text-error {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
    display: block;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 6px;
}

.alert-danger strong {
    display: block;
    margin-bottom: 8px;
}

.alert-danger ul {
    margin: 5px 0 0 20px;
    list-style-type: disc;
}

.alert-danger li {
    margin: 3px 0;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.btn-submit,
.btn-cancel {
    padding: 12px 25px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-submit {
    background-color: #8B1D3B;
    color: white;
    flex: 1;
}

.btn-submit:hover {
    background-color: #6a162d;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(139, 29, 59, 0.2);
}

.btn-cancel {
    background-color: #6c757d;
    color: white;
}

.btn-cancel:hover {
    background-color: #5a6268;
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
    .product-form-container {
        margin: 20px;
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-submit,
    .btn-cancel {
        width: 100%;
    }
}
</style>
@endsection