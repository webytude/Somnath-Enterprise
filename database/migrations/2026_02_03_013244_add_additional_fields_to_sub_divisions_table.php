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
        Schema::table('sub_divisions', function (Blueprint $table) {
            // Head of Sub Division Information
            $table->string('head_of_sub_division')->nullable()->after('division_id');
            $table->text('address')->nullable()->after('head_of_sub_division');
            $table->string('name_of_sub_div_head')->nullable()->after('address');
            $table->string('head_mobile_number', 20)->nullable()->after('name_of_sub_div_head');
            
            // Contact Person Information
            $table->string('sub_div_contact_person_name')->nullable()->after('head_mobile_number');
            $table->string('contact_person_name')->nullable()->after('sub_div_contact_person_name');
            $table->string('contact_person_mobile_number', 20)->nullable()->after('contact_person_name');
            
            // Remarks
            $table->text('remark')->nullable()->after('contact_person_mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_divisions', function (Blueprint $table) {
            $table->dropColumn([
                'head_of_sub_division',
                'address',
                'name_of_sub_div_head',
                'head_mobile_number',
                'sub_div_contact_person_name',
                'contact_person_name',
                'contact_person_mobile_number',
                'remark'
            ]);
        });
    }
};
