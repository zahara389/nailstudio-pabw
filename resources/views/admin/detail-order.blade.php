@extends('layouts.app-admin') 

@section('content')
<div class="head-title">
    <div class="left">
        <h1>Order Detail #{{ str_pad($order['id'], 3, '0', STR_PAD_LEFT) }}</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('dashboard.index') }}">Order/Transaction</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Detail</a></li>
        </ul>
    </div>
</div>

<div class="order-detail-page">
    <h2>Detail Pesanan</h2>

    <div class="card-group">
        <div class="card detail-card info-card">
            <h4>Informasi Pelanggan</h4>
            <p><strong>Nama:</strong> {{ htmlspecialchars($order['fullname']) }}</p>
            <p><strong>Status Order:</strong> 
                <span class="status-badge status-{{ strtolower($order['order_status']) }}">{{ $order['order_status'] }}</span>
            </p>
            <p><strong>Tanggal Order:</strong> {{ date('d M Y', strtotime($order['order_date'])) }}</p>
            <p><strong>Total Item:</strong> {{ $order['total_items'] }}</p>
        </div>
        
        <div class="card detail-card payment-card">
            <h4>Bukti Pembayaran</h4>
            @if ($order['file_path'])
                <img src="{{ asset('uploads/' . $order['file_path']) }}" alt="Bukti Pembayaran" class="bukti-bayar-img">
                <a href="{{ asset('uploads/' . $order['file_path']) }}" target="_blank" class="btn btn-sm btn-primary mt-2">Lihat Ukuran Penuh</a>
            @else
                <div class="alert alert-info">Bukti pembayaran belum diunggah oleh pelanggan.</div>
            @endif
        </div>
    </div>
    
    <h4 class="mt-4">Daftar Produk yang Dibeli</h4>
    <table class="table table-bordered item-table">
        <thead>
            <tr><th>Barang</th><th>Harga Satuan</th><th>Qty</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ htmlspecialchars($item['namaproduct']) }}</td>
                    <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-primary">
                <td colspan="3" class="text-end"><strong>GRAND TOTAL</strong></td>
                <td><strong>Rp {{ number_format($order['total'], 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
    
    <a href="{{ route('dashboard.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>
</div>
@endsection

@section('styles')
<style>
/* CSS khusus Order Detail */
.order-detail-page h2, .order-detail-page h4 { color: #8B1D3B; font-weight: 600; margin-bottom: 15px; }
.card-group { display: flex; gap: 20px; margin-bottom: 30px; }
.detail-card { flex: 1; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.payment-card img.bukti-bayar-img { max-width: 100%; height: auto; max-height: 250px; object-fit: contain; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; }
.item-table thead th { background-color: #f3f4f6; color: #333; }
.item-table tfoot td { font-size: 1.1em; font-weight: 700; background-color: #f5f5f5; }
</style>
@endsection