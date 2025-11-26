@extends('layouts.app-admin') 

@section('content')
<main>
    <div class="head-title">
        <div class="left">
            <h1>Transaction History</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('transaction.history') }}">Transaction History</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <div class="header"></div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Nama Pembeli</th>
                        <th>Daftar Barang</th>
                        <th>Harga per Item</th>
                        <th>Total Harga</th>
                        <th>Total Pembelian</th>
                    </tr>
                </thead>
                <tbody id="transactionTable">
                    @forelse ($transactions as $trans)
                        <tr>
                            <td>#{{ str_pad($trans['id'], 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ htmlspecialchars($trans['pembeli']) }}</td>
                            
                            {{-- Daftar Barang --}}
                            <td><ul>@foreach ($trans['barang'] as $b)<li>{{ htmlspecialchars($b) }}</li>@endforeach</ul></td>
                            
                            {{-- Harga per Item --}}
                            <td><ul>@foreach ($trans['harga'] as $h)<li>{{ $h }}</li>@endforeach</ul></td>
                            
                            {{-- Total Harga Transaksi --}}
                            <td>Rp {{ number_format($trans['total'], 0, ',', '.') }}</td>
                            
                            {{-- Total Item --}}
                            <td>{{ $trans['qty_total'] }} items</td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No completed transactions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div style='margin-top:20px;'>
            @if ($page > 1)
                <a href="{{ route('transaction.history', ['page' => $page - 1]) }}" style='margin-right: 10px;'>&laquo; Previous</a>
            @endif
            
            @if ($page < $totalPages)
                <a href="{{ route('transaction.history', ['page' => $page + 1]) }}">Next &raquo;</a>
            @endif
            
            @if ($totalRows > 0)
                <small style="margin-left: 15px;">Page {{ $page }} of {{ $totalPages }} (Total {{ $totalRows }} transactions)</small>
            @endif
        </div>
    </div>
</main>
@endsection

{{-- Pindahkan CSS Inline ke styles section di Layout Utama atau di sini --}}
@section('styles')
<style>
.table-container { margin: 32px 0; }
.table-container table { width: 100%; border-collapse: collapse; }
.table-container th, .table-container td { padding: 10px 12px; border-bottom: 1px solid #eee; text-align: left; }
.table-container th { background: #8B1D3B; color: #fff; }
.table-container tr:nth-child(even) { background: #faf8fb; }
a { text-decoration: none; color: #8B1D3B; font-weight: bold; }
a:hover { text-decoration: underline; }
</style>
@endsection