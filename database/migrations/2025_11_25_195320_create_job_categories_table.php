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
        // Duplicate placeholder migration; intentionally left empty.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op; handled by primary job_categories migration.
    }
};
