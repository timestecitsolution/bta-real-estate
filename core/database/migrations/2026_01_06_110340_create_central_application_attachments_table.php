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
        Schema::create('central_application_attachments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('central_application_id');

            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size')->nullable();

            $table->timestamps();

            $table->foreign(
                'central_application_id',
                'ca_app_attach_fk'
            )
            ->references('id')
            ->on('central_application')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('central_application_attachments');
    }
};
