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
        Schema::table('flat_booking', function (Blueprint $table) {
            $table->boolean('is_cancelled')
                ->default(0)
                ->after('emi_start_date');

            $table->text('cancel_reason')
                ->nullable()
                ->after('is_cancelled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flat_booking', function (Blueprint $table) {
            $table->dropColumn(['is_cancelled', 'cancel_reason']);
        });
    }
};
