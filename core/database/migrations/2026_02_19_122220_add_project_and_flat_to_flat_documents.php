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
        Schema::table('flat_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->after('booking_id');
            $table->unsignedBigInteger('flat_id')->after('project_id');

            $table->foreign('booking_id')
                ->references('id')
                ->on('flat_booking')
                ->onDelete('cascade');

            $table->foreign('project_id')
                ->references('id')
                ->on('topics')
                ->onDelete('cascade');

            $table->foreign('flat_id')
                ->references('id')
                ->on('flat_details')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flat_documents', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropForeign(['project_id']);
            $table->dropForeign(['flat_id']);

            $table->dropColumn(['project_id', 'flat_id']);
        });
    }
};
