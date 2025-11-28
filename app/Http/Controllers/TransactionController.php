<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // HAPUS function getAllDummyTransactions() !!
    // Kita ganti logika index() sepenuhnya memakai Database

    public function index(Request $request)
    {
        // PENTING: Mengambil data dari DATABASE sebagai OBJECT
        // 'with' mengambil relasi detail barang agar hemat query
        $transactions = Transaction::with('details')
                        ->latest()
                        ->paginate(5);

        // Kirim data ke view
        // $transactions di sini berisi Object Collection, bukan Array biasa
        return view('admin.transaction-history', compact('transactions'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'pembeli' => 'required|string',
            'items'   => 'required|array',
        ]);

        // Simpan ke Database
        DB::transaction(function () use ($request) {
            $trans = Transaction::create([
                'pembeli' => $request->pembeli
            ]);

            foreach ($request->items as $item) {
                // Pastikan key array sesuai dengan name di form HTML kamu
                // Contoh form: name="items[0][nama_product]"
                TransactionDetail::create([
                    'transaction_id' => $trans->id,
                    'nama_product'   => $item['nama_product'] ?? $item['namaproduct'] ?? 'Produk', // Handle typo nama key
                    'price'          => $item['price'],
                    'qty'            => $item['qty'],
                ]);
            }
        });

        return back()->with('success', 'Transaksi berhasil disimpan!');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID di database
        $trans = Transaction::findOrFail($id);
        
        // Hapus (Detail barang otomatis terhapus karena setting on delete cascade di migration)
        $trans->delete();

        return back()->with('success', 'Transaksi berhasil dihapus!');
    }
}