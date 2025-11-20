<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder produk yang baru kita buat
        $this->call([
            ProductSeeder::class,
        ]);
    }
}