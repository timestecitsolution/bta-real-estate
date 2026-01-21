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
        Schema::table('permissions', function (Blueprint $table) {
            $table->boolean('landlord_engagement')->default(0)->after('modules_status');
            $table->boolean('booking_details')->default(0)->after('landlord_engagement');
            $table->boolean('document_type')->default(0)->after('booking_details');
            $table->boolean('material_type')->default(0)->after('document_type');
            $table->boolean('client_application_subject')->default(0)->after('material_type');
            $table->boolean('application_list')->default(0)->after('client_application_subject');
            $table->boolean('client_visit_request')->default(0)->after('application_list');
            $table->boolean('land_query_list')->default(0)->after('client_visit_request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn([
                'landlord_engagement',
                'booking_details',
                'document_type',
                'material_type',
                'client_application_subject',
                'application_list',
                'client_visit_request',
                'land_query_list',
            ]);
        });
    }
};
