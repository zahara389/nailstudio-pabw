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
	public function run(): void
	{
		$faker = Faker::create('id_ID');

		$userIds = [];

		for ($i = 0; $i < 5; $i++) {
			$name = $faker->name;

			$user = User::create([
				'name'     => $name,
				'username' => Str::slug($name, '_') . rand(100, 999),
				'email'    => $faker->unique()->safeEmail,
				'password' => Hash::make('password'),
				'role'     => 'member',
			]);

			$userIds[] = $user->id;
		}

		$products = Product::all();

		if ($products->count() < 3) {
			for ($i = 1; $i <= 3; $i++) {
				$productName = 'Nail Polish Varian ' . $i;

				$product = Product::updateOrCreate(
					['slug' => Str::slug($productName)],
					[
						'name'        => $productName,
						'category'    => 'nail polish',
						'description' => 'Kutek premium varian ' . $i,
						'stock'       => 100,
						'price'       => 50000 * $i,
						'discount'    => 0,
						'status'      => 'published',
						'image'       => 'products/dummy.jpg',
						'rating'      => 4.0,
						'review_count'=> 0,
					]
				);

				if (!$products->contains(fn ($item) => $item->id === $product->id)) {
					$products->push($product);
				}
			}
		}

		if ($products->isEmpty()) {
			return;
		}

		$statuses = ['active', 'checked_out'];

		for ($i = 0; $i < 10; $i++) {
			$randomUserId = $userIds[array_rand($userIds)];

			$cart = Cart::create([
				'user_id' => $randomUserId,
				'status'  => $statuses[array_rand($statuses)],
			]);

			$itemsCount = rand(1, 4);

			for ($x = 0; $x < $itemsCount; $x++) {
				$product = $products->random();
				$qty = rand(1, 3);

				CartItem::create([
					'cart_id'    => $cart->id,
					'product_id' => $product->id,
					'quantity'   => $qty,
					'unit_price' => $product->price,
				]);
			}
		}
	}
}
