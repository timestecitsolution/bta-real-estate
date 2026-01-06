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
        Schema::table('central_application', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('applied_by');
            $table->unsignedBigInteger('flat_id')->nullable()->after('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('central_application', function (Blueprint $table) {
            $table->dropColumn(['project_id', 'flat_id']);
        });
    }
};
