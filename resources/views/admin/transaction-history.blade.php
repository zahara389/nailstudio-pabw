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
                        <th>Order</th>
                        <th>Pelanggan</th>
                        <th>Barang</th>
                        <th>Status Pembayaran</th>
                        <th>Total Harga</th>
                        <th>Total Item</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                                <div class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</div>
                            </td>
                            <td>
                                <div>{{ $order->user->name ?? 'Guest' }}</div>
                                <div class="text-muted">{{ $order->user->email ?? '-' }}</div>
                            </td>
                            <td>
                                <ul class="list-none">
                                    @foreach ($order->items as $item)
                                        <li>
                                            - {{ $item->product->name ?? 'Produk dihapus' }} (x{{ $item->quantity }})
                                            <div class="text-muted">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <div>{{ $order->payment_method ?? 'Manual Transfer' }}</div>
                                <div class="badge-status badge-status--{{ strtolower($order->order_status) }}">{{ $order->order_status }}</div>
                            </td>
                            <td>
                                <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                @if($order->discount_amount > 0)
                                    <div class="text-muted">Diskon Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td>{{ $order->items->sum('quantity') }} items</td>
                            <td>
                                <form action="{{ route('transaction.destroy', $order->id) }}"
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

        <div class="pagination-container">
            {{ $orders->links() }}
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

.text-muted {
    color: #6c757d;
    font-size: 12px;
}

.badge-status {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 999px;
    font-size: 12px;
    margin-top: 4px;
    text-transform: capitalize;
    background: #e9ecef;
    color: #343a40;
}

.badge-status--pending {
    background: #fff3cd;
    color: #856404;
}

.badge-status--processing {
    background: #cce5ff;
    color: #004085;
}

.badge-status--shipped {
    background: #d1ecf1;
    color: #0c5460;
}

.badge-status--completed {
    background: #d4edda;
    color: #155724;
}

.badge-status--cancelled {
    background: #f8d7da;
    color: #721c24;
}
</style>
@endsection
