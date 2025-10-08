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
            $table->decimal('emi_amount')->nullable()->change();
            $table->integer('extras_amount')->nullable()->change();
            $table->date('emi_due_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emi_payments', function (Blueprint $table) {
            $table->decimal('emi_amount')->nullable(false)->change();
            $table->integer('extras_amount')->nullable(false)->change();
            $table->date('emi_due_date')->nullable(false)->change();
        });
    }
};
