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
        Schema::table('landlord_engagements', function (Blueprint $table) {
            $table->dropForeign(['flat_id']);

            $table->foreign('flat_id')
                ->references('id')
                ->on('flat_details')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landlord_engagements', function (Blueprint $table) {
            $table->dropForeign(['flat_id']);

            // Restore old FK (tags table)
            $table->foreign('flat_id')
                ->references('id')
                ->on('tags')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
