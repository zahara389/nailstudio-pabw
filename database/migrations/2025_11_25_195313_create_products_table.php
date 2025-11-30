<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 150)->unique();
            $table->enum('category', ['nail polish','nail tools','nail care','nail kit']);
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 5, 2)->default(0);
            $table->enum('status', ['draft','published','low stock']);
            $table->string('image')->nullable();
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->integer('review_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
