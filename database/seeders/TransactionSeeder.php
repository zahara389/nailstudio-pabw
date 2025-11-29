<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'pembeli' => 'Tazkya Mutia',
                'tanggal_pembelian' => now()->subDays(1),
                'total_harga' => 150000,
                'status' => 'Selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pembeli' => 'Ayu Putri',
                'tanggal_pembelian' => now()->subDays(2),
                'total_harga' => 80000,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pembeli' => 'Sinta Rahma',
                'tanggal_pembelian' => now()->subDays(3),
                'total_harga' => 120000,
                'status' => 'Dibatalkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
