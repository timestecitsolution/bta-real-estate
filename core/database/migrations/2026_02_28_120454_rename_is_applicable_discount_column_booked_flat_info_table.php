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
        Schema::table('booked_flat_info', function (Blueprint $table) {
            $table->renameColumn('is_application_discount', 'is_applicable_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booked_flat_info', function (Blueprint $table) {
            $table->renameColumn('is_applicable_discount', 'is_application_discount');
        });
    }
};
