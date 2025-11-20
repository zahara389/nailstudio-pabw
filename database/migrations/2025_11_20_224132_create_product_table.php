<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('id_product'); // PK Custom
            $table->string('namaproduct', 100);
            $table->enum('category', ['nail polish', 'nail tools', 'nail care', 'nail kit'])->nullable();
            $table->integer('stock');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['draft', 'published', 'low stock']);
            $table->string('image');
            $table->decimal('discount', 5, 2)->default(0.00);
            $table->date('added');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};