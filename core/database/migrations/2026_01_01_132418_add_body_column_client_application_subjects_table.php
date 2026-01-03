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
        Schema::table('client_application_subjects', function (Blueprint $table) {
            $table->longText('body')->nullable()->after('subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_application_subjects', function (Blueprint $table) {
            $table->dropColumn('body');
        });
    }
};
