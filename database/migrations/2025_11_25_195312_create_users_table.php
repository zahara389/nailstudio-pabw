<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
<<<<<<< HEAD
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->enum('role', ['admin','member'])->default('member');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
=======
        if (!Schema::hasTable('users')) {
            // Superseded by earlier users migration.
                $table->enum('role', ['admin','member'])->default('member');
                $table->string('phone', 20)->nullable();
                $table->text('address')->nullable();
                $table->string('city', 100)->nullable();
                $table->string('postal_code', 10)->nullable();
                $table->string('photo')->nullable();
                $table->enum('status', ['active','inactive'])->default('active');
            // No-op
                $table->rememberToken();
                $table->timestamps();
            });
        }
>>>>>>> 410293de228d06d1edd09366863acedcb1863f6f
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
