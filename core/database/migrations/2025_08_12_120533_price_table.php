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
        Schema::create('price', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->integer('flat_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('emi', 10, 2)->nullable();
            $table->decimal('booking_amount', 10, 2)->nullable();
            $table->decimal('downpayment_amount', 10, 2)->nullable();
            $table->integer('emi_count')->nullable();
            $table->date('emi_start_date')->nullable();
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
        Schema::dropIfExists('price');
    }
};
