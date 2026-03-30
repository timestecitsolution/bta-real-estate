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
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'emi_id')) {
                $table->renameColumn('emi_id', 'emi_payment_id');
            }

            if (Schema::hasColumn('invoices', 'price_id')) {
                $table->renameColumn('price_id', 'booking_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'emi_payment_id')) {
                $table->renameColumn('emi_payment_id', 'emi_id');
            }

            if (Schema::hasColumn('invoices', 'booking_id')) {
                $table->renameColumn('booking_id', 'price_id');
            }
        });
    }
};
