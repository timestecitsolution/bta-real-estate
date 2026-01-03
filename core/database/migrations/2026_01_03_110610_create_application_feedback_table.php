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
        Schema::create('application_feedback', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('application_id');
            $table->text('feedback')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // Foreign keys (optional but recommended)
            $table->foreign('application_id')
                  ->references('id')
                  ->on('central_application')
                  ->onDelete('cascade');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('contacts')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_feedback');
    }
};
