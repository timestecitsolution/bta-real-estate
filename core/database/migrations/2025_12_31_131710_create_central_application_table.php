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
        Schema::create('central_application', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('applied_by');
            $table->longText('body');
            $table->enum('status', ['pending', 'approved', 'rejected', 'hold'])->default('pending');
            $table->longText('feedback')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('subject_id')->references('id')->on('client_application_subjects')->onDelete('cascade');
            $table->foreign('applied_by')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('central_application');
    }
};
