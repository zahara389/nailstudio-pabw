<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke orders
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // Relasi ke products
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->integer('quantity');
            
            // PERUBAHAN: Sesuai screenshot (sebelumnya saya kira 'price')
            $table->decimal('unit_price', 10, 2); 
            
            // TAMBAHAN: Ada kolom discount_amount juga di item
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0.00);
            
            // PERUBAHAN: Sesuai screenshot (sebelumnya saya kira 'subtotal')
            $table->decimal('subtotal_item', 12, 2); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};