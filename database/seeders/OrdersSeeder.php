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

        // =====================================================
        // 1. Generate USERS (5 user)
        // =====================================================
        $userIds = [];

        for ($i = 0; $i < 5; $i++) {

            $name = $faker->name;

            $user = User::create([
                'name'      => $name,
                'username'  => Str::slug($name, '_') . rand(10, 999),
                'email'     => $faker->unique()->safeEmail,
                'password'  => Hash::make('password'),
                'role'      => 'member'
            ]);

            $userIds[] = $user->id;
        }

        // =====================================================
        // 2. Generate 3 PRODUCT DUMMY
        // =====================================================
        $products = [];

        for ($i = 1; $i <= 3; $i++) {
            $productName = 'Nail Polish Varian ' . $i;

            $products[] = Product::firstOrCreate(
                ['name' => $productName],
                [
                    'slug'        => Str::slug($productName),
                    'description' => 'Kutek premium varian ' . $i,
                    'price'       => 50000 * $i,
                    'stock'       => 100,
                    'image'       => 'products/dummy.jpg'
                ]
            );
        }

        // =====================================================
        // 3. Generate CARTS (10 cart)
        // =====================================================
        $statuses = ['pending', 'processing', 'shipped', 'completed'];

        for ($i = 0; $i < 10; $i++) {

            $randomUser = $userIds[array_rand($userIds)];

            // Buat Cart
            $cart = Cart::create([
                'user_id'    => $randomUser,
                'status'     => $statuses[array_rand($statuses)],
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
            ]);

            // =====================================================
            // 4. Generate 1–4 ITEM per cart
            // =====================================================
            $itemsCount = rand(1, 4);
            $totalPrice = 0;

            for ($x = 0; $x < $itemsCount; $x++) {

                $product = $products[array_rand($products)];

                $qty = rand(1, 3);
                $subtotal = $product->price * $qty;

                CartItem::create([
                    'cart_id'    => $cart->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'unit_price' => $product->price,
                ]);

                $totalPrice += $subtotal;
            }

            // Update total price (jika tabel cart-mu punya kolom total_price)
            if (isset($cart->total_price)) {
                $cart->update(['total_price' => $totalPrice]);
            }
        }
    }
}
