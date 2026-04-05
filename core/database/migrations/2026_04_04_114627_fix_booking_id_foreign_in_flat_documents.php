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
        Schema::table('flat_documents', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            // new FK add (flat_booking)
            $table->foreign('booking_id')
                ->references('id')
                ->on('flat_booking')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flat_documents', function (Blueprint $table) {
             $table->dropForeign(['booking_id']);
            // restore old FK (price table)
            $table->foreign('booking_id')
                ->references('id')
                ->on('price')
                ->onDelete('cascade');
        });
    }
};
