<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            
            // Relasi ke orders
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            
            // Relasi ke products
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            
            $table->integer('quantity');
            
            $table->decimal('unit_price', 10, 2); 
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('subtotal_item', 12, 2); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
