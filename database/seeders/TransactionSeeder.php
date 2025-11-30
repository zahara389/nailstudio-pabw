<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            return;
        }

        $orders = [
            [
                'customer' => 'Tazkya Mutia',
                'status' => 'Completed',
                'discount' => 10000,
                'items' => [
                    ['quantity' => 1, 'product' => $products->get(0) ?? $products->first()],
                    ['quantity' => 2, 'product' => $products->get(1) ?? $products->first()],
                ],
            ],
            [
                'customer' => 'Ayu Putri',
                'status' => 'Pending',
                'discount' => 0,
                'items' => [
                    ['quantity' => 1, 'product' => $products->get(2) ?? $products->first()],
                ],
            ],
            [
                'customer' => 'Sinta Rahma',
                'status' => 'Cancelled',
                'discount' => 5000,
                'items' => [
                    ['quantity' => 1, 'product' => $products->get(3) ?? $products->first()],
                ],
            ],
        ];

        foreach ($orders as $index => $payload) {
            $customer = $users->firstWhere('name', $payload['customer']) ?? $users->random();

            $order = Order::create([
                'user_id' => $customer->id,
                'order_number' => 'ORD-' . Str::upper(Str::random(8)),
                'total_amount' => 0,
                'payment_method' => 'Manual Transfer',
                'proof_of_payment_path' => null,
                'order_status' => $payload['status'],
                'discount_amount' => (float) $payload['discount'],
            ]);

            $total = 0;

            foreach ($payload['items'] as $item) {
                $product = $item['product'] instanceof Product
                    ? $item['product']
                    : $products->random();

                $quantity = max(1, $item['quantity']);
                $unitPrice = $product->price;
                $subtotal = $quantity * $unitPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_amount' => 0,
                    'subtotal_item' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update([
                'total_amount' => max(0, $total - (float) $payload['discount']),
            ]);
        }
    }
}
