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
<<<<<<< HEAD
            
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
=======
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('subtotal_item', 12, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
>>>>>>> 410293de228d06d1edd09366863acedcb1863f6f
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};