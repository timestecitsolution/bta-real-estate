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
        Schema::create('client_notice_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notice_id');
            $table->foreign('notice_id')
                ->references('id')
                ->on('client_notice')
                ->onDelete('cascade');
            $table->enum('reviewer_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reviewer_feedback')->nullable();
            $table->enum('s_admin_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('s_admin_feedback')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->unsignedBigInteger('s_admin_actioned_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('s_admin_actioned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_notice_feedback');
    }
};
