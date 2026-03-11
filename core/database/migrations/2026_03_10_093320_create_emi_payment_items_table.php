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
        Schema::create('emi_payment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emi_payment_id');
            $table->unsignedBigInteger('flat_id');
            $table->enum('charge_type', ['EMI','GAS','PARKING','UTILITY','MAINTENANCE','OTHER'])->default('EMI');
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('extras_amount', 15, 2)->default(0);
            $table->enum('status', ['Paid','Partial','Unpaid'])->default('Unpaid');
            $table->date('emi_due_date')->nullable();
            $table->date('emi_paid_date')->nullable();
            $table->timestamps();
            $table->foreign('emi_payment_id')->references('id')->on('emi_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_payment_items');
    }
};
