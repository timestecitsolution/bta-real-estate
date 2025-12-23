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
        Schema::table('engagement_project_documents', function (Blueprint $table) {
            if (Schema::hasColumn('engagement_project_documents', 'engagement_id')) {
                $table->dropForeign(['engagement_id']);
                $table->dropColumn('engagement_id');
            }

            // project_id add
            $table->unsignedBigInteger('project_id')->after('id');

            $table->foreign('project_id')
                ->references('id')
                ->on('topics')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('engagement_project_documents', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');

            $table->unsignedBigInteger('engagement_id')->nullable();
        });
    }
};
