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
        Schema::create('smartend_booking_queries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255);
            $table->string('email', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('passport_no', 9)->nullable();
            $table->string('nid_no', 17)->nullable();
            $table->string('nid_front_pic', 255)->nullable();
            $table->string('nid_back_pic', 255)->nullable();
            $table->string('birth_certificate_no', 17)->nullable();
            $table->string('project_id', 50)->nullable();
            $table->string('flat_id', 19)->nullable();
            $table->date('preferred_date')->nullable();
            $table->text('message')->nullable();
            $table->boolean('agreed_privacy')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smartend_booking_queries');
    }
};
