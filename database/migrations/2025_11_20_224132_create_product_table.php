<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key standar (id)
            $table->string('name', 500); // Diperpanjang untuk menghindari truncate
            $table->string('slug', 500)->unique();
            $table->string('category', 500); // Ubah dari ENUM jadi VARCHAR agar fleksibel
            $table->integer('stock')->default(0);
            $table->decimal('price', 12, 2); // 12 digit total, 2 desimal
            $table->integer('discount')->default(0); // Dalam persen (0-100)
            $table->enum('status', ['draft', 'published', 'low stock', 'out of stock'])->default('draft');
            $table->string('image', 500)->nullable();
            $table->timestamps(); // Otomatis bikin created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};