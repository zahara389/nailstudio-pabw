<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel FAQ (Digunakan untuk pesan masuk dan tampilan FAQ)
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            // user_id dibuat nullable jika pengirim pesan adalah tamu (guest)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('question'); 
            $table->text('answer')->nullable(); 
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });
    } // <--- Tadi kamu lupa menutup kurung kurawal ini

    public function down()
    {
        // Hapus tabel faqs saja karena hanya ini yang dibuat di fungsi up
        Schema::dropIfExists('faqs');
    }
};