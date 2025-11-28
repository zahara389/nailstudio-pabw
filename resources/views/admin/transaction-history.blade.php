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
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
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
                        <th>Aksi</th> <!-- Tambahan Kolom Aksi -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $trans)
                        <tr>
                            <!-- ID -->
                            <td>#{{ str_pad($trans->id, 3, '0', STR_PAD_LEFT) }}</td>
                            
                            <!-- Nama Pembeli -->
                            <td>{{ $trans->pembeli }}</td>
                            
                            <!-- Daftar Barang (Looping dari Relasi) -->
                            <td>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    @foreach ($trans->details as $detail)
                                        <li>- {{ $detail->nama_product }} (x{{ $detail->qty }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            
                            <!-- Harga per Item -->
                            <td>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    @foreach ($trans->details as $detail)
                                        <li>Rp {{ number_format($detail->price, 0, ',', '.') }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            
                            <!-- Total Harga (Dari Accessor Model) -->
                            <td>
                                <strong>Rp {{ number_format($trans->total_transaksi, 0, ',', '.') }}</strong>
                            </td>
                            
                            <!-- Total Qty (Dari Accessor Model) -->
                            <td>{{ $trans->total_qty }} items</td>

                            <!-- Tombol Delete -->
                            <td>
                                <form action="{{ route('transaction.destroy', $trans->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION LARAVEL BAWAAN (Lebih Rapi) --}}
        <div style="margin-top: 20px;">
            {{ $transactions->links() }} 
        </div>
    </div>
</main>
@endsection

@section('styles')
<style>
.table-container { margin: 32px 0; overflow-x: auto; }
.table-container table { width: 100%; border-collapse: collapse; min-width: 800px; }
.table-container th, .table-container td { padding: 12px 15px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: top; }
.table-container th { background: #8B1D3B; color: #fff; }
.table-container tr:nth-child(even) { background: #faf8fb; }
.table-container tr:hover { background-color: #f1f1f1; }

/* Custom Laravel Pagination Style (Optional) */
.pagination { display: flex; list-style: none; padding: 0; }
.pagination li { margin-right: 5px; }
.pagination li a, .pagination li span { padding: 8px 12px; border: 1px solid #ddd; color: #8B1D3B; text-decoration: none; }
.pagination li.active span { background-color: #8B1D3B; color: white; border-color: #8B1D3B; }
</style>
@endsection