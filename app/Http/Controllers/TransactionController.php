<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua transaksi + detail
        $transactions = Transaction::with('details')
                        ->latest()
                        ->paginate(5);

        // Hitung total harga setiap transaksi
        foreach ($transactions as $t) {
            $t->total_harga = $t->details->sum(function ($d) {
                return $d->harga * $d->qty;
            });
        }

        return view('admin.transaction-history', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string',
            'items'   => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $trans = Transaction::create([
                'pembeli' => $request->pembeli
            ]);

            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $trans->id,
                    'nama_produk'    => $item['nama_produk'] 
                                        ?? $item['namaproduct'] 
                                        ?? 'Produk',
                    'harga'          => $item['harga'] ?? $item['price'],
                    'qty'            => $item['qty'],
                ]);
            }
        });

        return back()->with('success', 'Transaksi berhasil disimpan!');
    }

    public function destroy($id)
    {
        $trans = Transaction::findOrFail($id);
        $trans->delete();

        return back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
