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
        Schema::table('price', function (Blueprint $table) {
            $table->integer('flat_size')->after('flat_id')->nullable();
            $table->enum('is_negotiable_total_price', ['0', '1'])->after('downpayment_amount')->nullable();
            $table->integer('price_per_sqft')->after('customer_id')->nullable();
            $table->decimal('due_amount', 10, 2)->after('downpayment_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price', function (Blueprint $table) {
            $table->dropColumn('flat_size');
            $table->dropColumn('is_negotiable_total_price');
            $table->dropColumn('price_per_sqft');
            $table->dropColumn('due_amount');
        });
    }
};
