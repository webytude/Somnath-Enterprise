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
        Schema::table('parties', function (Blueprint $table) {
            $table->string('pancard')->nullable()->after('gst');
            $table->string('bank_account_holder_name')->nullable()->after('remark');
            $table->string('bank_name_branch')->nullable()->after('bank_account_holder_name');
            $table->string('bank_account_no')->nullable()->after('bank_name_branch');
            $table->string('ifsc_code', 20)->nullable()->after('bank_account_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parties', function (Blueprint $table) {
            $table->dropColumn(['pancard', 'bank_account_holder_name', 'bank_name_branch', 'bank_account_no', 'ifsc_code']);
        });
    }
};
