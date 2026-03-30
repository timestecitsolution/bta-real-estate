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
        Schema::table('emi_payments', function (Blueprint $table) {
            $table->decimal('total_extras', 15, 2)
                  ->nullable()
                  ->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emi_payments', function (Blueprint $table) {
            Schema::table('emi_payments', function (Blueprint $table) {
                $table->dropColumn('total_extras');
            });
        });
    }
};
