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
            $table->enum('type', ['notice', 'application'])->after('body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_application_subjects', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
