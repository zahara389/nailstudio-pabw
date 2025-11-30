<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transaction_details')->insert([
            // Transaksi ID 1
            [
                'transaction_id' => 1,
                'nama_produk' => 'Nail Art Premium',
                'harga' => 100000,
                'qty' => 1,
            ],
            [
                'transaction_id' => 1,
                'nama_produk' => 'Soft Gel',
                'harga' => 50000,
                'qty' => 1,
            ],

            // Transaksi ID 2
            [
                'transaction_id' => 2,
                'nama_produk' => 'Classic Nail Art',
                'harga' => 80000,
                'qty' => 1,
            ],

            // Transaksi ID 3
            [
                'transaction_id' => 3,
                'nama_produk' => 'Hand Spa',
                'harga' => 70000,
                'qty' => 1,
            ],
            [
                'transaction_id' => 3,
                'nama_produk' => 'Nail Art Deluxe',
                'harga' => 50000,
                'qty' => 1,
            ],
        ]);
    }
}
