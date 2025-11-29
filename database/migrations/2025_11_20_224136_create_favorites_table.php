<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
<<<<<<<< HEAD:database/migrations/2025_11_25_195313_create_products_table.php
        Schema::create('products', function (Blueprint $table) {
            $table->id();
========
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
>>>>>>>> tazkya:database/migrations/2025_11_20_224136_create_favorites_table.php
            $table->timestamps();

            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2025_11_25_195313_create_products_table.php
        Schema::dropIfExists('products');
========
        Schema::dropIfExists('favorites');
>>>>>>>> tazkya:database/migrations/2025_11_20_224136_create_favorites_table.php
    }
};
