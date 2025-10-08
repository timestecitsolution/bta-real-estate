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
        Schema::create('emi_payments', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('price_id');
            $table->foreign('price_id')->references('id')->on('price')->onDelete('cascade');

            $table->decimal('emi_amount', 12, 2);   
            $table->date('emi_due_date');           
            $table->date('emi_paid_date')->nullable(); 
            $table->enum('status', ['pending', 'paid'])->default('pending');

            $table->decimal('remaining_due', 12, 2)->nullable(); 
            $table->integer('remaining_emi_count')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_payments');
    }
};
