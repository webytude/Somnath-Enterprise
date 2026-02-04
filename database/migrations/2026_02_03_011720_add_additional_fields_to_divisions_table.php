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
        Schema::table('divisions', function (Blueprint $table) {
            // Basic Information - Head of Division
            $table->string('head_of_division_name')->nullable()->after('subdepartment_id');
            $table->text('address')->nullable()->after('head_of_division_name');
            $table->string('head_mobile_number', 20)->nullable()->after('address');
            $table->string('contact_number', 20)->nullable()->after('head_mobile_number');
            
            // Contact Person Information
            $table->string('contact_person_name')->nullable()->after('contact_number');
            $table->string('contact_person_mobile_number', 20)->nullable()->after('contact_person_name');
            
            // Bank Information
            $table->string('bank_name')->nullable()->after('contact_person_mobile_number');
            $table->string('bank_account_no', 50)->nullable()->after('bank_name');
            $table->string('ifsc_code', 20)->nullable()->after('bank_account_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn([
                'head_of_division_name',
                'address',
                'head_mobile_number',
                'contact_number',
                'contact_person_name',
                'contact_person_mobile_number',
                'bank_name',
                'bank_account_no',
                'ifsc_code'
            ]);
        });
    }
};
