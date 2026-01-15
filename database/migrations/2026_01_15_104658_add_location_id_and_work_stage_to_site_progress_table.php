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
        Schema::table('site_progress', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('id')->constrained('locations')->onDelete('set null');
            $table->text('work_stage')->nullable()->after('work_site');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_progress', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn(['location_id', 'work_stage']);
        });
    }
};
