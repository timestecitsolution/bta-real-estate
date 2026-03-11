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
        Schema::table('legacy_emi_payments', function (Blueprint $table) {
            Schema::rename('emi_payments', 'legacy_emi_payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legacy_emi_payments', function (Blueprint $table) {
            Schema::rename('legacy_emi_payments', 'emi_payments');
        });
    }
};
