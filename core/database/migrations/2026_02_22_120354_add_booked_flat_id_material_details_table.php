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
        Schema::table('material_details', function (Blueprint $table) {
            $table->unsignedBigInteger('booked_flat_id')->nullable()->after('booking_id');
            $table->foreign('booked_flat_id')->references('id')->on('booked_flat_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_details', function (Blueprint $table) {
            $table->dropForeign(['booked_flat_id']);
            $table->dropColumn('booked_flat_id');
        });
    }
};
