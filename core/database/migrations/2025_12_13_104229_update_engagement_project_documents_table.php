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

            // engagement_id থাকলে drop করো
            if (Schema::hasColumn('engagement_project_documents', 'engagement_id')) {
                $table->dropForeign(['engagement_id']);
                $table->dropColumn('engagement_id');
            }

            // project_id না থাকলেই add করবে
            if (!Schema::hasColumn('engagement_project_documents', 'project_id')) {
                $table->unsignedBigInteger('project_id')->after('id');

                $table->foreign('project_id')
                    ->references('id')
                    ->on('topics')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('engagement_project_documents', function (Blueprint $table) {

            if (Schema::hasColumn('engagement_project_documents', 'project_id')) {
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            }

            if (!Schema::hasColumn('engagement_project_documents', 'engagement_id')) {
                $table->unsignedBigInteger('engagement_id')->nullable();
            }
        });
    }

};
