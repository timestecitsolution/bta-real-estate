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
        Schema::table('emi_tables', function (Blueprint $table) {
            // emi_payments table
            DB::statement("
                ALTER TABLE smartend_emi_payments 
                MODIFY status ENUM('Paid', 'Unpaid', 'Partial', 'Pending') DEFAULT 'Pending'
            ");

            // emi_payment_items table
            DB::statement("
                ALTER TABLE smartend_emi_payment_items 
                MODIFY status ENUM('Paid', 'Unpaid', 'Partial', 'Pending') DEFAULT 'Pending'
            ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emi_tables', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE smartend_emi_payments 
                MODIFY status ENUM('Paid', 'Unpaid', 'Partial') DEFAULT 'Unpaid'
            ");

            DB::statement("
                ALTER TABLE smartend_emi_payment_items 
                MODIFY status ENUM('Paid', 'Unpaid', 'Partial') DEFAULT 'Unpaid'
            ");
        });
    }
};
