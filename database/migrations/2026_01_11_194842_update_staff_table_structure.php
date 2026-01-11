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
        Schema::table('staff', function (Blueprint $table) {
            // Remove name column
            $table->dropColumn('name');
            
            // Add new name fields
            $table->string('first_name')->after('code');
            $table->string('last_name')->after('first_name');
            $table->string('second_name')->nullable()->after('last_name'); // surname/second name
            
            // Add IFSC code after bank_account_no
            $table->string('ifsc_code', 20)->nullable()->after('bank_account_no');
            
            // Remove nominee fields
            $table->dropColumn(['nominee_name', 'nominee_relation']);
            
            // Add other contact number
            $table->string('other_contact_number', 20)->nullable()->after('mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // Re-add name column
            $table->string('name')->after('code');
            
            // Remove new name fields
            $table->dropColumn(['first_name', 'last_name', 'second_name']);
            
            // Remove IFSC code
            $table->dropColumn('ifsc_code');
            
            // Re-add nominee fields
            $table->string('nominee_name')->nullable()->after('blood_group');
            $table->string('nominee_relation')->nullable()->after('nominee_name');
            
            // Remove other contact number
            $table->dropColumn('other_contact_number');
        });
    }
};
