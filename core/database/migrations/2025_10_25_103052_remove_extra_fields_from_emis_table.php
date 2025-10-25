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
            if (Schema::hasColumn('emi_payments', 'remaining_due')) {
                $table->dropColumn('remaining_due');
            }
            if (Schema::hasColumn('emi_payments', 'total_paid_amount')) {
                $table->dropColumn('total_paid_amount');
            }
            if (Schema::hasColumn('emi_payments', 'total_paid_amount_with_extras')) {
                $table->dropColumn('total_paid_amount_with_extras');
            }
            if (Schema::hasColumn('emi_payments', 'remaining_due_amount_with_extras')) {
                $table->dropColumn('remaining_due_amount_with_extras');
            }
            if (Schema::hasColumn('emi_payments', 'remaining_emi_count')) {
                $table->dropColumn('remaining_emi_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emi_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('emi_payments', 'remaining_due')) {
                $table->decimal('remaining_due', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('emi_payments', 'total_paid_amount')) {
                $table->decimal('total_paid_amount', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('emis', 'total_paid_amount_with_extras')) {
                $table->decimal('total_paid_amount_with_extras', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('emi_payments', 'remaining_due_amount_with_extras')) {
                $table->decimal('remaining_due_amount_with_extras', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('emi_payments', 'remaining_emi_count')) {
                $table->integer('remaining_emi_count')->nullable();
            }
        });
    }
};
