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
        Schema::create('client_notice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')
              ->constrained('client_application_subjects')
              ->restrictOnDelete();
            $table->text('notice_body');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_notice');
    }
};
