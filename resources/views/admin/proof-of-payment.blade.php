@extends('layouts.app-admin')

@section('content')
<div class="head-title">
    <div class="left">
        <h1>Proof of Payment</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('dashboard.orders.show', $order->id) }}">Order Detail</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Proof</a></li>
        </ul>
    </div>
</div>

<div class="order-detail-page">
    <div class="card-group">
        <div class="card detail-card payment-card">
            <h4>Foto Bukti Pembayaran</h4>
            <img src="{{ route('dashboard.orders.proof.image', $order->id) }}" alt="Bukti Pembayaran" class="bukti-bayar-img">
            <a href="{{ route('dashboard.orders.proof.image', $order->id) }}" target="_blank" class="btn btn-sm btn-primary mt-2">Buka Gambar</a>
        </div>

        <div class="card detail-card info-card">
            <h4>Metadata & Pelanggan</h4>
            <p><strong>Nama:</strong> {{ $order->user->name ?? 'Pelanggan' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
            <p><strong>Order:</strong> {{ $order->order_number ?? ('#' . str_pad($order->id, 3, '0', STR_PAD_LEFT)) }}</p>
            <p><strong>Tanggal Order:</strong> {{ $order->created_at?->format('d M Y H:i') }}</p>
            <hr>
            <p><strong>File:</strong> {{ $metadata['file_name'] }}</p>
            <p><strong>Tipe:</strong> {{ $metadata['mime_type'] }}</p>
            <p><strong>Ukuran:</strong> {{ number_format($metadata['size_bytes'] / 1024, 1) }} KB</p>
            <p><strong>Terakhir diubah:</strong> {{ $metadata['last_modified']->format('d M Y H:i') }}</p>
            @if(!empty($metadata['width']) && !empty($metadata['height']))
                <p><strong>Dimensi:</strong> {{ $metadata['width'] }}×{{ $metadata['height'] }}</p>
            @endif
        </div>
    </div>

    <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn btn-secondary mt-3">Kembali ke Detail Order</a>
</div>
@endsection

@section('styles')
<style>
.order-detail-page h4 { color: #8B1D3B; font-weight: 600; margin-bottom: 15px; }
.card-group { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
.detail-card { flex: 1; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.payment-card img.bukti-bayar-img { max-width: 100%; height: auto; max-height: 420px; object-fit: contain; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; background: #fafafa; }
</style>
@endsection
