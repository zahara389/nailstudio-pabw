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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2025_11_25_195314_create_cart_items_table.php
            $table->timestamps();
=======
            $table->unsignedBigInteger('cart_id');
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->foreign('cart_id')
                  ->references('id')
                  ->on('carts') // FIX HERE
                  ->onDelete('cascade');
>>>>>>> tazkya:database/migrations/2025_11_20_224134_create_bukti_bayar_table.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
