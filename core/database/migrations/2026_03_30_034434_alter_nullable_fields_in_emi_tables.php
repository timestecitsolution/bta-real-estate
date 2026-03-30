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
            $table->decimal('total_amount', 12, 2)->nullable()->change();
        });

        Schema::table('emi_payment_items', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->nullable()->change();
            $table->decimal('extras_amount', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emi_payments', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->nullable(false)->change();
        });

        Schema::table('emi_payment_items', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->nullable(false)->change();
            $table->decimal('extras_amount', 12, 2)->nullable(false)->change();
        });
    }
};
