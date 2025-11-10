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
            $table->text('change_details')->nullable()->after('details');

            // ENUM status: builtin, pending, approved, rejected
            $table->enum('status', ['builtin', 'pending', 'approved', 'rejected'])
                  ->default('builtin')
                  ->after('change_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_details', function (Blueprint $table) {
            $table->dropColumn(['change_details', 'status']);
        });
    }
};
