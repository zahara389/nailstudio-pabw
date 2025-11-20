<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('cart')->cascadeOnDelete();
            // Konek ke 'id_product' di tabel 'product'
            $table->foreignId('product_id')->constrained('product', 'id_product')->cascadeOnDelete();
            $table->integer('qty')->default(1);
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item');
    }
};