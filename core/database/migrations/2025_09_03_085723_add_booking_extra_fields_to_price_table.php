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
        Schema::table('price', function (Blueprint $table) {
            $table->boolean('is_applicable_govt_gas')->default(0);
            $table->boolean('is_govt_gas_connection_paid')->default(0);
            $table->enum('govt_gas_connection_payment_scheme', ['downpayment', 'emi', 'handover'])->nullable();
            $table->decimal('gas_amount', 12, 2)->nullable();

            $table->boolean('is_applicable_parking')->default(0);
            $table->boolean('is_parking_paid')->default(0);
            $table->enum('parking_payment_scheme', ['downpayment', 'emi', 'others'])->nullable();
            $table->decimal('parking_amount', 12, 2)->nullable();

            $table->boolean('is_utility_included')->default(0);
            $table->enum('utility_payment_scheme', ['downpayment', 'emi', 'others'])->nullable();
            $table->decimal('utility_amount', 12, 2)->nullable();

            $table->decimal('extras_amount', 12, 2)->nullable();
            $table->boolean('is_discount_applicable')->default(0);
            $table->decimal('discount_amount', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price', function (Blueprint $table) {
            $table->dropColumn([
                'is_applicable_govt_gas',
                'is_govt_gas_connection_paid',
                'govt_gas_connection_payment_scheme',
                'gas_amount',
                'is_applicable_parking',
                'is_parking_paid',
                'parking_payment_scheme',
                'parking_amount',
                'is_utility_included',
                'utility_payment_scheme',
                'utility_amount',
                'extras_amount',
                'is_discount_applicable',
                'discount_amount',
            ]);
        });
    }
};
