<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2025_11_25_195321_create_job_applications_table.php
=======
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('applicant_name', 100);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('cv_filename');
            $table->text('description')->nullable();
            $table->enum('status', ['new','reviewed','interview','rejected'])->default('new');
>>>>>>> tazkya:database/migrations/2025_11_20_224137_create_job_applications_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
