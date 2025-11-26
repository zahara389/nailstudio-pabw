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

    {{-- PENTING: Mengganti $orders menjadi $recent_orders dan memastikan count() berjalan --}}
    <ul class="box-info">
        <li>
            <i class='bx bxs-calendar-check'></i>
            {{-- FIX: Menggunakan $recent_orders --}}
            <span class="text"><h3>{{ count($recent_orders) }}</h3><p>Recent Orders</p></span> 
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text"><h3>{{ $total_login }}</h3><p>Visitors Today</p></span>
        </li>
        <li>
            <i class='bx bx-wallet'></i>
            <span class="text"><h3>Rp {{ number_format($total_sales, 0, ',', '.') }}</h3><p>Total Sales</p></span>
        </li>
        <li>
            <i class='bx bx-line-chart'></i>
            <span class="text"><h3>{{ $total_register }}</h3><p>Register</p></span>
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
                {{-- FIX: Mengganti $orders menjadi $recent_orders --}}
                @foreach ($recent_orders as $order)
                    <tr>
                        {{-- Data Model Laravel menggunakan -> property access, BUKAN ['key'] --}}
                        <td>#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                        {{-- FIX: Menggunakan relasi user dan accessor getNameAttribute dari Model User --}}
                        <td>{{ htmlspecialchars($order->user->name ?? 'User Dihapus') }}</td> 
                        {{-- Menggunakan created_at atau order_date dari Model Cart --}}
                        <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td> 
                        
                        {{-- KARENA RELASI ITEMS BELUM DI-LOAD DI SINI, KITA SIMULASIKAN DULU, 
                             IDEALNYA DATA ITEMS DIAMBIL DARI $order->items --}}
                        <td>
                             <ul>
                                 {{-- ASUMSI: $order->items adalah relasi ke CartItem --}}
                                 @if($order->items->count())
                                     @foreach ($order->items->take(2) as $item)
                                         <li>{{ htmlspecialchars($item->product->name ?? 'Produk') }} x {{ $item->quantity }}</li>
                                     @endforeach
                                     @if($order->items->count() > 2)
                                        <li>... dan {{ $order->items->count() - 2 }} lainnya</li>
                                     @endif
                                 @else
                                     <li>Detail item belum tersedia</li>
                                 @endif
                             </ul>
                        </td>
                        {{-- Kolom Harga per Item dihapus karena sulit ditampilkan di loop utama,
                             kita fokus ke Total Harga --}}
                        
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        
                        {{-- Bukti Bayar (perlu kolom file_path di tabel cart) --}}
                        <td>
                            @if ($order->file_path)
                                <a href="{{ asset('uploads/' . $order->file_path) }}" target="_blank" class="text-blue-600 underline">View</a>
                            @else
                                <span class="text-gray-400 text-sm">None</span>
                            @endif
                        </td>
                        
                        {{-- Status dan Update --}}
                        <td>
                            <form method="post" action="{{ route('dashboard.updateStatus') }}">
                                @csrf 
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <select name="new_status" onchange="this.form.submit()" class="status-select status-{{ strtolower($order->order_status) }}">
                                    @php $statuses = ['Pending', 'Processing', 'Shipped', 'Completed']; @endphp
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ url('order_detail/' . $order->id) }}" class="btn-detail-black-text text-sm bg-pink-600 px-3 py-1 rounded hover:bg-pink-700 transition">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
<style>
/* FIX: Teks Header (TH) menjadi Hitam */
.table-container th {
    color: #000000 !important; 
}

/* FIX: Tombol Detail menjadi Hitam */
.btn-detail-black-text {
    color: #000000 !important;
}
/* Tambahan styling untuk select status */
.status-select {
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 14px;
    cursor: pointer;
    background-color: #f9f9f9;
}
.status-pending { background-color: #ffcccc; color: #cc0000; border-color: #cc0000; }
.status-processing { background-color: #fffacd; color: #b8860b; border-color: #b8860b; }
.status-shipped { background-color: #add8e6; color: #00008b; border-color: #00008b; }
.status-completed { background-color: #90ee90; color: #006400; border-color: #006400; }

</style>
@endsection