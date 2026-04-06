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
        // booked_flat_info table
        Schema::table('booked_flat_info', function (Blueprint $table) {
            $table->date('booking_date_flat')->nullable()->after('emi_start_date_flat');
        });

        // transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->date('paid_date')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booked_flat_info', function (Blueprint $table) {
            $table->dropColumn('booking_date_flat');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('paid_date');
        });
    }
};
