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
            $table->string('relative_name')->nullable()->after('other_contact_number');
            $table->string('relation')->nullable()->after('relative_name');
            $table->string('relative_mobile_no', 20)->nullable()->after('relation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['relative_name', 'relation', 'relative_mobile_no']);
        });
    }
};
