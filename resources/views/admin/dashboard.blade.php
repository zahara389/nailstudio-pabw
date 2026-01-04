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

    @if(session('success'))
        <div style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; margin-bottom: 20px;">
            <i class='bx bxs-check-circle'></i> {{ session('success') }}
        </div>
    @endif

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
        <div class="table-header">
            <h3 class="title-text">Recent Orders</h3>
        </div>
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
                @forelse ($recent_orders as $order)
                    <tr>
                        <td class="dark-text">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="customer-name">{{ $order->user->name ?? 'Guest' }}</div>
                            <small class="customer-email">{{ $order->user->email ?? '' }}</small>
                        </td>
                        <td class="dark-text">{{ $order->created_at->format('d-m-Y') }}</td>
                        <td class="dark-text">
                            <ul class="item-list">
                                @foreach ($order->items->take(2) as $item)
                                    <li>{{ $item->product->name ?? 'Produk' }} (x{{ $item->quantity }})</li>
                                @endforeach
                                @if($order->items->count() > 2)
                                    <li class="more-items">+{{ $order->items->count() - 2 }} lainnya...</li>
                                @endif
                            </ul>
                        </td>
                        <td class="price-text">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if ($order->proof_of_payment_path)
                                <a href="{{ route('dashboard.orders.proof.show', $order->id) }}" class="proof-link">
                                    View Image
                                </a>
                            @else
                                <span class="no-proof">No Proof</span>
                            @endif
                        </td>
                        <td>
                            <form method="post" action="{{ route('dashboard.updateStatus') }}">
                                @csrf 
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <select name="new_status" class="status-select status-{{ strtolower($order->order_status) }}" onchange="this.form.submit()">
                                    @foreach (['Pending','Processing','Shipped','Completed','Cancelled'] as $status)
                                        <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn-detail">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
<style>
    /* 1. MENGHITAMKAN TEXT (Koreksi Utama) */
    .table-container .title-text {
        color: #000000 !important;
        font-weight: 700;
        margin-bottom: 15px;
    }

    /* Header Tabel Hitam */
    .table-container table thead tr th {
        color: #000000 !important;
        font-weight: 800 !important; /* Sangat Tebal */
        border-bottom: 2px solid #eee;
        padding: 12px;
    }

    /* Isi Tabel Hitam */
    .dark-text, .customer-name, .price-text {
        color: #000000 !important;
        font-weight: 500;
    }

    .customer-name {
        font-weight: 700;
    }

    .customer-email {
        color: #444 !important; /* Abu gelap agar tetap terbaca */
    }

    .no-proof {
        color: #000000 !important; /* Hitam sesuai permintaan */
        font-weight: bold;
        opacity: 0.6;
    }

    /* 2. STYLING TABEL & LIST */
    .table-container {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .item-list {
        list-style: none; 
        padding: 0; 
        font-size: 13px;
        line-height: 1.4;
    }

    .more-items {
        color: #777 !important;
        font-style: italic;
    }

    /* 3. BUTTONS & LINKS */
    .btn-detail {
        background-color: #fce4ec;
        color: #e91e63 !important;
        padding: 6px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: 0.3s;
        border: 1px solid #f8bbd0;
        display: inline-block;
    }

    .btn-detail:hover {
        background-color: #e91e63;
        color: #fff !important;
    }

    .proof-link {
        color: #e91e63;
        text-decoration: underline;
        font-size: 13px;
        font-weight: 600;
    }

    /* 4. STATUS DROPDOWN COLORS */
    .status-select {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        outline: none;
        border: 1px solid transparent;
    }
    
    .status-pending { background: #fff3e0; color: #ef6c00; border-color: #ffe0b2; }
    .status-processing { background: #e3f2fd; color: #1565c0; border-color: #bbdefb; }
    .status-shipped { background: #f3e5f5; color: #7b1fa2; border-color: #e1bee7; }
    .status-completed { background: #e8f5e9; color: #2e7d32; border-color: #c8e6c9; }
    .status-cancelled { background: #ffebee; color: #c62828; border-color: #ffcdd2; }

    .empty-state {
        text-align: center; 
        padding: 50px; 
        color: #999;
        font-weight: 600;
    }
</style>
@endsection