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
        Schema::table('emi_payments', function (Blueprint $table) {
            $table->decimal('total_paid_amount', 15, 2)->nullable()->after('remaining_due');
            $table->decimal('total_paid_amount_with_extras', 15, 2)->nullable()->after('total_paid_amount');
            $table->decimal('remaining_due_amount_with_extras', 15, 2)->nullable()->after('total_paid_amount_with_extras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emi_payments', function (Blueprint $table) {
            $table->dropColumn([
                'total_paid_amount',
                'total_paid_amount_with_extras',
                'remaining_due_amount_with_extras',
            ]);
        });
    }
};
