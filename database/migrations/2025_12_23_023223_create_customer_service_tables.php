<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel FAQ (Kelola Pertanyaan Sering Ditanyakan)
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
        });

        // 2. Tabel Contacts (Pesan User & Balasan Admin)
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message'); 
            $table->text('admin_reply')->nullable();
            $table->boolean('is_read')->default(false); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('faqs');
    }
};