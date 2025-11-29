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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('namaproduct');
            $table->string('category')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedBigInteger('price');
            $table->string('status')->default('draft');
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('discount')->default(0);
            $table->text('description')->nullable();
            $table->timestamp('added')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
