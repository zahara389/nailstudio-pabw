@extends('layouts.app-admin')

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Stock Management</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Stock Management</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('stock.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" 
                                   placeholder="Cari nama produk..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 text-muted fw-semibold" style="width: 50px;">#</th>
                        <th class="text-muted fw-semibold" style="width: 100px;">Gambar</th>
                        <th class="text-muted fw-semibold">Nama Produk</th>
                        <th class="text-muted fw-semibold">Kategori</th>
                        <th class="text-muted fw-semibold text-center">Stock</th>
                        <th class="text-muted fw-semibold">Harga</th>
                        <th class="text-muted fw-semibold text-center">Status</th>
                        <th class="text-muted fw-semibold text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td class="ps-4 text-muted">
                            {{ $loop->iteration + ($products->currentPage()-1) * $products->perPage() }}
                        </td>
                        <td>
                            <img src="{{ asset($product->image) }}" 
                                 class="rounded shadow-sm border"
                                 style="width: 60px; height: 60px; object-fit: cover;"
                                 alt="{{ $product->name }}">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $product->name }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-info text-dark" style="font-size: 0.85rem; min-width: 45px;">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="text-center">
                            @if($product->status == 'published')
                                <span class="badge bg-success-subtle text-success border border-success px-3">Published</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3">Draft</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-warning btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#editStockModal{{ $product->id }}">
                                    <i class="bi bi-box-seam"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#editPriceModal{{ $product->id }}">
                                    <i class="bi bi-currency-dollar"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="editStockModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('stock.updateStock', $product->id) }}" method="POST" class="w-100">
                                @csrf @method('PUT')
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title fw-bold">Update Stok</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-1 text-muted small">Produk: <strong>{{ $product->name }}</strong></p>
                                        <div class="mt-3">
                                            <label class="form-label fw-semibold">Jumlah Stok Baru</label>
                                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" min="0" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning fw-bold">Simpan Stok</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" id="editPriceModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('stock.updatePrice', $product->id) }}" method="POST" class="w-100">
                                @csrf @method('PUT')
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold">Update Harga</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-1 text-muted small">Produk: <strong>{{ $product->name }}</strong></p>
                                        <div class="mt-3">
                                            <label class="form-label fw-semibold">Harga Baru (Rp)</label>
                                            <input type="number" name="price" class="form-control" value="{{ $product->price }}" min="0" step="500" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary fw-bold">Simpan Harga</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <p class="text-muted mb-0">Tidak ada produk yang ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top py-3">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <small class="text-muted">
                        Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                    </small>
                </div>
                <div class="col-md-6 d-flex justify-content-center justify-content-md-end">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection