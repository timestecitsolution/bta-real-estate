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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->enum('payment_type', ['emi', 'booking']);
            $table->unsignedBigInteger('emi_id')->nullable();
            $table->unsignedBigInteger('price_id')->nullable();
            $table->unsignedBigInteger('client_id'); 
            $table->decimal('total_price', 15, 2)->default(0); 
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('emi_id')->references('id')->on('emi_payments')->onDelete('set null');
            $table->foreign('price_id')->references('id')->on('price')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
