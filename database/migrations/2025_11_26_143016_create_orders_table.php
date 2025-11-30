<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('order_number', 50)->unique();
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method', 50)->nullable();
            $table->string('proof_of_payment_path', 255)->nullable();

            $table->enum('order_status', [
                'Pending',
                'Processing',
                'Shipped',
                'Completed',
                'Cancelled'
            ])->default('Pending');

            $table->decimal('discount_amount', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
