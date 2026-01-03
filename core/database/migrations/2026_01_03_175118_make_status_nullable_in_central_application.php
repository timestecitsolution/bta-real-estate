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
        DB::statement("
            ALTER TABLE smartend_central_application 
            MODIFY COLUMN status ENUM('pending','approved','rejected','hold') NULL DEFAULT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE smartend_central_application 
            MODIFY COLUMN status ENUM('pending','approved','rejected','hold') NOT NULL DEFAULT 'pending'
        ");
    }
};
