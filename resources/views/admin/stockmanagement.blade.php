@extends('layouts.app-admin')

@section('content')
<div class="container py-4">

    <h3 class="mb-4">Stock Management</h3>

    
    <form method="GET" action="{{ route('stock.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari produk..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status')=='published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

   
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stock</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration + ($products->currentPage()-1) * $products->perPage() }}</td>

                        <td>
                            <img src="{{ asset($product->image) }}" width="60" height="60" class="rounded">
                        </td>

                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>

                        <td>
                            <span class="badge bg-info">{{ $product->stock }}</span>
                        </td>

                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>

                        <td>
                            @if($product->status == 'published')
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>

                        <td>

                            <!-- Edit Stock Button -->
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editStockModal{{ $product->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                           
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editPriceModal{{ $product->id }}">
                                <i class="bi bi-cash"></i>
                            </button>

                        </td>
                    </tr>

                    
                    <div class="modal fade" id="editStockModal{{ $product->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('stock.updateStock', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Stock</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label>Stock Baru</label>
                                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-warning">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <div class="modal fade" id="editPriceModal{{ $product->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('stock.updatePrice', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Harga</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label>Harga Baru</label>
                                        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>

           
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
