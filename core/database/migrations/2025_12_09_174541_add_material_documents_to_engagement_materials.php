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
        Schema::table('engagement_materials', function (Blueprint $table) {
            $table->string('material_documents')
                ->nullable()
                ->after('material_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('engagement_materials', function (Blueprint $table) {
            $table->dropColumn('material_documents');
        });
    }
};
