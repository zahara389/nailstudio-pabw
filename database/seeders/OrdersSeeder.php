<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // ---------------------------------------
        // 1. Buat 5 user
        // ---------------------------------------
        $userIds = [];

        for ($k = 0; $k < 5; $k++) {
            $name = $faker->name;

            $user = User::create([
                'name' => $name,
                'username' => Str::slug($name, '_') . rand(1, 999),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'member'
            ]);

            $userIds[] = $user->id;
        }

        // ---------------------------------------
        // 2. Produk dummy
        // ---------------------------------------
        $products = [];
        for ($i = 1; $i <= 3; $i++) {
            $productName = 'Nail Polish Varian ' . $i;
            $products[] = Product::firstOrCreate(
                ['name' => $productName],
                [
                    'slug' => Str::slug($productName),
                    'description' => 'Kutek kualitas premium nomor ' . $i,
                    'price' => 50000 * $i,
                    'stock' => 100,
                    'image' => 'products/dummy.jpg'
                ]
            );
        }

        // ---------------------------------------
        // 3. BUAT 10 CARTS
        // ---------------------------------------

        // === STATUS SESUAI MIGRATION ===
        $statuses = ['pending', 'processing', 'shipped', 'completed'];

        for ($j = 0; $j < 10; $j++) {

            $randomUserId = $userIds[array_rand($userIds)];

            // Header Cart
            $cart = Cart::create([
                'user_id' => $randomUserId,
                'status' => $statuses[array_rand($statuses)],   // <= disesuaikan
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);

            // Item cart
            $randomProduct = $products[rand(0, 2)];

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $randomProduct->id,
                'quantity' => rand(1, 3),
                'unit_price' => $randomProduct->price,
            ]);
        }
    }
}
