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
        Schema::create('landlord_engagements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('landlord_id'); 
            $table->unsignedBigInteger('flat_id')->nullable();

            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('landlord_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('flat_id')->references('id')->on('tags')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlord_engagements');
    }
};
