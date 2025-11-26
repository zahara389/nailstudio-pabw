<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('order_number', 50);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method', 50)->nullable();
            $table->string('proof_of_payment_path', 255)->nullable();
            
            // Sesuai enum di gambar: Complete (tanpa d)
            $table->enum('order_status', ['Pending', 'Processing', 'Shipped', 'Complete'])
                  ->default('Pending');
            
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0.00);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};