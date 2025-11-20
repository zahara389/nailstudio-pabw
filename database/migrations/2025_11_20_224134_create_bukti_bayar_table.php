<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_bayar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('cart')->cascadeOnDelete();
            $table->string('file_path');
            $table->timestamp('uploaded_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_bayar');
    }
};