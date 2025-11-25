@extends('layouts.app-admin') 

@section('content')
<div class="head-title">
    <div class="left">
        <h1>Products</h1>
        <ul class="breadcrumb">
            {{-- Menggunakan route() untuk link Dashboard --}}
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route('product.index') }}">Product</a></li>
        </ul>
    </div>
</div>

{{-- Pesan Notifikasi (Menggantikan $_SESSION) --}}
@if (session('success')) 
    <div class="alert alert-success">{{ session('success') }}</div> 
@endif
@if (session('error')) 
    <div class="alert alert-danger">{{ session('error') }}</div> 
@endif

<div class="product-page">
    <div class="header-actions">
        <h2>Product Management</h2>
        {{-- Link Add Product --}}
        <a href="{{ route('product.create') }}" class="btn-add">Add Product</a>
    </div>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search products..." onkeyup="searchProducts()">
    </div>

    <div class="table-container">
        <table id="productTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Price After Discount</th>
                    <th>Status</th>
                    <th>Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- $formattedProducts dikirim dari ProductAdminController --}}
                @forelse ($formattedProducts as $product)
                    <tr>
                        <td>
                            <div class="product-info">
                                {{-- Menggunakan helper asset() untuk gambar --}}
                                <img src="{{ asset('uploads/' . $product['image']) }}" alt="{{ $product['name'] }}">
                                <span>{{ $product['name'] }}</span>
                            </div>
                        </td>
                        <td>{{ $product['category'] }}</td>
                        <td>{{ $product['stock'] }}</td>
                        <td>Rp{{ $product['price'] }}</td>
                        <td>{{ $product['discount'] }}%</td>
                        <td>Rp{{ $product['price_discounted'] }}</td>
                        {{-- Status Badge --}}
                        <td><span class="status-badge {{ $product['status_class'] }}">{{ $product['status_text'] }}</span></td>
                        <td>{{ $product['added_date'] }}</td>
                        <td class="action-buttons">
                            {{-- Edit Link --}}
                            <a href="{{ route('product.edit', $product['id']) }}" class="btn-edit">Edit</a>
                            
                            {{-- Delete Form (Harus POST/DELETE di Laravel) --}}
                            <form action="{{ route('product.destroy', $product['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="no-data">No products found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

{{-- Pindahkan JavaScript ke Section Scripts --}}
@section('scripts')
<script>
// Search function for products
function searchProducts() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("productTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
@endsection

{{-- Pindahkan CSS ke Section Styles --}}
@section('styles')
<style>
/* FIX CSS: Menargetkan TH di dalam table-container agar teks hitam (#000000) */
.table-container th {
    color: #000000 !important; 
}
/* Salin semua CSS yang terkait dengan produk (product-page, header-actions, status-badge, dll.) dari kode Native Anda ke sini */
.product-page { padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
.header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.btn-add { background-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 500; }
.search-bar { margin-bottom: 20px; text-align: right; }
#searchInput { padding: 8px 12px; width: 250px; border: 1px solid #ddd; border-radius: 4px; }
.table-container { overflow-x: auto; }
#productTable { width: 100%; border-collapse: collapse; }
#productTable th, #productTable td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
#productTable th { background-color: #f8f9fa; font-weight: 600; }
.product-info { display: flex; align-items: center; }
.product-info img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; margin-right: 10px; }
.status-badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; text-align: center; min-width: 100px; }
.status-published { background-color: #28a745; color: white; }
.status-draft { background-color: #6c757d; color: white; }
.status-low { background-color: #ffc107; color: white; }
.action-buttons a { text-decoration: none; margin-right: 10px; }
.btn-edit { color: #007bff; }
.btn-delete { color: #dc3545; }
.no-data, .error-message { text-align: center; padding: 20px; color: #6c757d; }
.error-message { color: #dc3545; }
</style>
@endsection