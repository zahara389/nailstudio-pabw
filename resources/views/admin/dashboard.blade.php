@extends('layouts.app-admin') 

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Order/Transaction</a></li>
            </ul>
        </div>
    </div>

    
    <ul class="box-info">
        <li>
            <i class='bx bxs-calendar-check'></i>
            <span class="text">
                <h3>{{ $recent_orders->count() }}</h3>
                <p>Recent Orders</p>
            </span> 
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>{{ $total_login }}</h3>
                <p>Visitors Today</p>
            </span>
        </li>
        <li>
            <i class='bx bx-wallet'></i>
            <span class="text">
                <h3>Rp {{ number_format($total_sales, 0, ',', '.') }}</h3>
                <p>Total Sales</p>
            </span>
        </li>
        <li>
            <i class='bx bx-line-chart'></i>
            <span class="text">
                <h3>{{ $total_register }}</h3>
                <p>Register</p>
            </span>
        </li>
    </ul>

    
    <div class="table-container">
        <h3>Recent Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pembeli</th>
                    <th>Tanggal Pembelian</th>
                    <th>Daftar Barang</th>
                    <th>Total Harga</th>
                    <th>Bukti Bayar</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($recent_orders as $order)
                    <tr>
                        <td>#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>

                        <td>{{ $order->user->name ?? 'User Dihapus' }}</td>

                        <td>{{ $order->created_at->format('d-m-Y') }}</td>

                        <td>
                            <ul>
                                @if($order->items->count())
                                    @foreach ($order->items->take(2) as $item)
                                        <li>{{ $item->product->name ?? 'Produk' }} x {{ $item->quantity }}</li>
                                    @endforeach

                                    @if($order->items->count() > 2)
                                        <li>... dan {{ $order->items->count() - 2 }} lainnya</li>
                                    @endif

                                @else
                                    <li>-</li>
                                @endif
                            </ul>
                        </td>

                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>

                        <td>
                            @if ($order->proof_of_payment_path)
                                <a href="{{ asset($order->proof_of_payment_path) }}" 
                                   target="_blank" 
                                   class="text-blue-600 underline">
                                   View
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">None</span>
                            @endif
                        </td>

                        {{-- STATUS DROPDOWN --}}
                        <td>
                            <form method="post" action="{{ route('dashboard.updateStatus') }}">
                                @csrf 
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <select name="new_status"
                                        class="status-select status-{{ strtolower($order->order_status) }}"
                                        onchange="this.form.submit()">

                                    @php
                                        $statuses = ['Pending','Processing','Shipped','Completed','Cancelled'];
                                    @endphp

                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" 
                                            {{ $order->order_status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>

                        <td>
                                     <a href="{{ route('dashboard.orders.show', $order->id) }}" 
                               class="btn-detail-black-text text-sm bg-pink-600 px-3 py-1 rounded hover:bg-pink-700 transition">
                               Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
<style>
/* Header tabel hitam */
.table-container th {
    color: #000 !important;
}

/* Button detail */
.btn-detail-black-text {
    color: #000 !important;
}

/* Dropdown umum */
.status-select {
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
    cursor: pointer;
    font-weight: 600;
}

/* STATUS COLORS */
.status-pending { 
    background-color: #ffe5e5 !important; 
    color: #cc0000 !important; 
    border-color: #cc0000 !important; 
}

.status-processing { 
    background-color: #fff8cd !important; 
    color: #b8860b !important; 
    border-color: #b8860b !important; 
}

.status-shipped { 
    background-color: #d6ecff !important; 
    color: #00509e !important; 
    border-color: #00509e !important; 
}

.status-completed { 
    background-color: #d5ffd5 !important; 
    color: #007f00 !important; 
    border-color: #007f00 !important; 
}

.status-cancelled {
    background-color: #fde2e1 !important;
    color: #b31b1b !important;
    border-color: #b31b1b !important;
}
</style>
@endsection
