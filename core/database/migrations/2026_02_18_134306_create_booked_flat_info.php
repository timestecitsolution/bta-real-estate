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
        Schema::create('booked_flat_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('flat_id');

            $table->decimal('flat_size', 10, 2); 
            $table->boolean('is_negotiate_total_price')->default(false);
            $table->decimal('price_per_sqft', 15, 2); 

            // Govt Gas
            $table->boolean('is_govt_gas_included')->default(false);
            $table->boolean('is_govt_gas_connection_paid')->default(false);
            $table->enum('govt_gas_payment_scheme', ['downpayment', 'emi', 'others'])->nullable(); // downpayment / emi / others
            $table->decimal('gas_connection_fee', 15, 2)->nullable();

            // Parking
            $table->boolean('is_parking_included')->default(false);
            $table->boolean('is_parking_paid')->default(false);
            $table->enum('parking_payment_scheme', ['downpayment', 'emi', 'others'])->nullable(); // downpayment / emi / others
            $table->decimal('parking_fee', 15, 2)->nullable();

            // Utility
            $table->boolean('is_utility_included')->default(false);
            $table->enum('utility_payment_scheme', ['downpayment', 'emi', 'others'])->nullable(); 
            $table->decimal('utility_fee', 15, 2)->nullable();

            $table->boolean('is_application_discount')->default(false);
            $table->decimal('discounted_amount', 15, 2)->nullable();

            $table->decimal('total_price_flat', 15, 2); 
            $table->decimal('emi_amount_flat', 15, 2)->nullable(); 
            $table->date('emi_start_date_flat')->nullable(); 

            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('flat_id')->references('id')->on('flat_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booked_flat_info');
    }
};
