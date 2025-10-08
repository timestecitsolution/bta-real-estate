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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('nid_front')->nullable()->after('photo');                
            $table->string('nid_back')->nullable()->after('nid_front');             
            $table->string('nid_no', 17)->nullable()->after('nid_back');            
            $table->string('passport_no', 9)->nullable()->after('nid_no');          
            $table->string('birth_certificate_no', 17)->nullable()->after('passport_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['nid_front', 'nid_back', 'nid_no', 'passport_no', 'birth_certificate_no']);
        });
    }
};
