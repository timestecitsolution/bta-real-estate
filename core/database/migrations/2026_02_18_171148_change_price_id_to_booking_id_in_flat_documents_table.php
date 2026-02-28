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
            $table->renameColumn('price_id', 'booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flat_documents', function (Blueprint $table) {
            $table->renameColumn('booking_id', 'price_id');
        });
    }
};
