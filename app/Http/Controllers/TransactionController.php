<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private function getAllDummyTransactions()
    {
        // Data lengkap simulasi transaksi (ID, Nama Pembeli)
        $transactions = [
            ['id' => 301, 'pembeli' => 'Joko Santoso'],
            ['id' => 302, 'pembeli' => 'Siti Aisyah'],
            ['id' => 303, 'pembeli' => 'Budi Setiawan'],
            ['id' => 304, 'pembeli' => 'Rina Wijaya'],
            ['id' => 305, 'pembeli' => 'Ferry Gunawan'],
            ['id' => 306, 'pembeli' => 'Diana Sari'],
            ['id' => 307, 'pembeli' => 'Andi Pratama'],
            ['id' => 308, 'pembeli' => 'Maya Kartika'],
            ['id' => 309, 'pembeli' => 'Rizky Putra'],
            ['id' => 310, 'pembeli' => 'Lina Dewi'],
        ];

        // Simulasi detail cart item (untuk nested loop)
        $items = [
            301 => [['namaproduct' => 'Polish A', 'price' => 250000, 'qty' => 1]],
            302 => [['namaproduct' => 'UV Lamp', 'price' => 800000, 'qty' => 1], ['namaproduct' => 'Buffer', 'price' => 50000, 'qty' => 2]],
            303 => [['namaproduct' => 'Top Coat', 'price' => 150000, 'qty' => 3]],
            304 => [['namaproduct' => 'Polish B', 'price' => 250000, 'qty' => 2]],
            305 => [['namaproduct' => 'Remover', 'price' => 45000, 'qty' => 5]],
            // Lanjutkan data detail untuk ID 306 hingga 310...
            306 => [['namaproduct' => 'Polish C', 'price' => 150000, 'qty' => 1]],
            307 => [['namaproduct' => 'Tools Kit', 'price' => 300000, 'qty' => 1]],
            308 => [['namaproduct' => 'Gel Pen', 'price' => 90000, 'qty' => 2]],
            309 => [['namaproduct' => 'Sticker', 'price' => 20000, 'qty' => 10]],
            310 => [['namaproduct' => 'Cleaner', 'price' => 60000, 'qty' => 4]],
        ];

        // Gabungkan data
        $formatted = [];
        foreach ($transactions as $trans) {
            $cart_id = $trans['id'];
            $barang_list = [];
            $harga_list = [];
            $total_transaksi = 0;
            $qty_total = 0;

            if (isset($items[$cart_id])) {
                foreach ($items[$cart_id] as $item) {
                    $barang_list[] = $item['namaproduct'] . " x" . $item['qty'];
                    $harga_list[]  = 'Rp ' . number_format($item['price'], 0, ',', '.');
                    $total_transaksi += $item['price'] * $item['qty'];
                    $qty_total += $item['qty'];
                }
            }

            $formatted[] = array_merge($trans, [
                'barang' => $barang_list,
                'harga' => $harga_list,
                'total' => $total_transaksi,
                'qty_total' => $qty_total
            ]);
        }

        return $formatted;
    }

    public function index(Request $request)
    {
        $allTransactions = $this->getAllDummyTransactions();
        $totalRows = count($allTransactions);
        $limit = 5;
        
        // Menggantikan logika $page, $limit, $offset PHP Native
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $limit;
        $totalPages = ceil($totalRows / $limit);

        // Simulasi LIMIT dan OFFSET
        $transactions = array_slice($allTransactions, $offset, $limit);

        return view('admin/transaction-history', compact(
            'transactions', 'page', 'totalPages', 'totalRows'
        ));
    }
}
