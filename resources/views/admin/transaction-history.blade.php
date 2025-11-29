@extends('layouts.app-admin')

@section('content')
<main>
    <div class="head-title">
        <div class="left">
            <h1>Transaction History</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Transaction History</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pembeli</th>
                        <th>Daftar Barang</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Total Item</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transactions as $trans)
                        <tr>
                            {{-- ID --}}
                            <td>#{{ str_pad($trans->id, 3, '0', STR_PAD_LEFT) }}</td>

                            {{-- Nama Pembeli --}}
                            <td>{{ $trans->pembeli }}</td>

                            {{-- Daftar Barang --}}
                            <td>
                                <ul class="list-none">
                                    @foreach ($trans->details as $detail)
                                        <li>- {{ $detail->nama_product }} (x{{ $detail->qty }})</li>
                                    @endforeach
                                </ul>
                            </td>

                            {{-- Harga Satuan --}}
                            <td>
                                <ul class="list-none">
                                    @foreach ($trans->details as $detail)
                                        <li>Rp {{ number_format($detail->price, 0, ',', '.') }}</li>
                                    @endforeach
                                </ul>
                            </td>

                            {{-- Total Harga --}}
                            <td>
                                <strong>Rp {{ number_format($trans->total_transaksi, 0, ',', '.') }}</strong>
                            </td>

                            {{-- Total Item --}}
                            <td>{{ $trans->total_qty }} items</td>

                            {{-- Tombol Delete --}}
                            <td>
                                <form action="{{ route('transaction.destroy', $trans->id) }}" 
                                      method="POST"
                                      onsubmit="return confirm('Hapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pagination-container">
            {{ $transactions->links() }}
        </div>
    </div>
</main>
@endsection


@section('styles')
<style>
/* Alert */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
}

/* Table */
.table-container { 
    margin: 32px 0; 
    overflow-x: auto;
}

.table-container table { 
    width: 100%; 
    border-collapse: collapse; 
    min-width: 900px; 
}

.table-container th, 
.table-container td { 
    padding: 12px 15px; 
    border-bottom: 1px solid #ddd; 
    vertical-align: top; 
    text-align: left;
}

.table-container th { 
    background: #8B1D3B; 
    color: #fff; 
}

.table-container tr:nth-child(even) { 
    background: #faf8fb; 
}

.table-container tr:hover { 
    background-color: #f1f1f1; 
}

.list-none {
    list-style: none;
    padding: 0;
    margin: 0;
}

/* Delete Button */
.btn-delete {
    background: #dc3545;
    color: white;
    border: none;
    padding: 6px 12px;
    cursor: pointer;
    border-radius: 4px;
}
.btn-delete:hover {
    background: #bb2d3b;
}

/* Pagination */
.pagination-container {
    margin-top: 20px;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
}
.pagination li {
    margin-right: 5px;
}
.pagination li a,
.pagination li span {
    padding: 8px 12px;
    border: 1px solid #ddd;
    color: #8B1D3B;
    text-decoration: none;
    border-radius: 4px;
}
.pagination li.active span {
    background-color: #8B1D3B;
    color: white;
    border-color: #8B1D3B;
}
</style>
@endsection
