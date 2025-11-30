<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Rose Glow Nail Polish',
                'category' => 'nail polish',
                'description' => 'Kutek warna rose glow dengan finishing glossy tahan lama.',
                'stock' => 120,
                'price' => 75000,
                'discount' => 10,
                'status' => 'published',
                'image' => 'products/rose-glow.jpg',
                'rating' => 4.5,
                'review_count' => 48,
            ],
            [
                'name' => 'Precision Nail Tools Kit',
                'category' => 'nail tools',
                'description' => 'Set peralatan manicure profesional untuk perawatan kuku sehari-hari.',
                'stock' => 80,
                'price' => 125000,
                'discount' => 5,
                'status' => 'published',
                'image' => 'products/nail-tools-kit.jpg',
                'rating' => 4.7,
                'review_count' => 27,
            ],
            [
                'name' => 'Vitamin Cuticle Oil',
                'category' => 'nail care',
                'description' => 'Minyak kutikula dengan vitamin E untuk menutrisi kuku agar tidak kering.',
                'stock' => 150,
                'price' => 55000,
                'discount' => 0,
                'status' => 'published',
                'image' => 'products/cuticle-oil.jpg',
                'rating' => 4.3,
                'review_count' => 19,
            ],
            [
                'name' => 'Complete Nail Art Kit',
                'category' => 'nail kit',
                'description' => 'Paket lengkap nail art dengan kuas, glitter, dan stiker dekoratif.',
                'stock' => 60,
                'price' => 185000,
                'discount' => 15,
                'status' => 'published',
                'image' => 'products/nail-art-kit.jpg',
                'rating' => 4.8,
                'review_count' => 34,
            ],
        ];

        foreach ($products as $product) {
            $slug = Str::slug($product['name']);

            Product::updateOrCreate(
                ['slug' => $slug],
                array_merge($product, ['slug' => $slug])
            );
        }
    }
}
