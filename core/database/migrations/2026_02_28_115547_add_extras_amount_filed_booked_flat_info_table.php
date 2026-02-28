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
        Schema::table('booked_flat_info', function (Blueprint $table) {
            $table->decimal('extras_amount', 15, 2)->default(0)->after('utility_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booked_flat_info', function (Blueprint $table) {
            $table->dropColumn('extras_amount');
        });
    }
};
