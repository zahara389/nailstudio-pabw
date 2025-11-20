<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('product', 'id_product')->nullOnDelete();
            
            $table->float('rating')->nullable();
            $table->integer('packaging')->nullable();
            $table->integer('pigmentation')->nullable();
            $table->integer('longwear')->nullable();
            $table->integer('texture')->nullable();
            $table->integer('value_for_money')->nullable();
            
            $table->enum('recommend', ['Yes', 'No'])->nullable();
            $table->enum('repurchase', ['Yes', 'Maybe', 'No'])->nullable();
            $table->string('usage_period')->nullable();
            $table->string('tag')->nullable();
            
            $table->text('comment')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};