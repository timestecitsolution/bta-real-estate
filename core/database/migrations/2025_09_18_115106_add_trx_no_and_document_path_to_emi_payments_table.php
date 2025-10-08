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
            $table->string('trx_no')->nullable()->after('remaining_emi_count'); 
            $table->string('document_path')->nullable()->after('trx_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emi_payments', function (Blueprint $table) {
            $table->dropColumn(['trx_no', 'document_path']);
        });
    }
};
