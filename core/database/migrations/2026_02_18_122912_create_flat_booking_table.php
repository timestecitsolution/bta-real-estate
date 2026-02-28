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
        Schema::create('flat_booking', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('client_id'); 
            $table->boolean('is_discount_applicable_total')->default(false); 
            $table->decimal('discount_amount_total', 15, 2)->nullable(); 
            $table->decimal('total_price', 15, 2); 
            $table->decimal('booking_amount', 15, 2)->nullable();
            $table->decimal('downpayment_amount', 15, 2)->nullable(); 
            $table->decimal('extras_total', 15, 2)->nullable()->nullable(); 
            $table->decimal('due_amount_total', 15, 2)->nullable();
            $table->decimal('total_emi_amount', 15, 2)->nullable(); 
            $table->integer('emi_count')->nullable(); 
            $table->boolean('is_emi_date_combined')->default(false)->nullable(); 
            $table->date('emi_start_date')->nullable(); 
            $table->timestamps();

            // Foreign key
            $table->foreign('client_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flat_booking');
    }
};
