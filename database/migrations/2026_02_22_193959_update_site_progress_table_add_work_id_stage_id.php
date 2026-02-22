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
            $table->foreignId('work_id')->nullable()->after('location_id')->constrained('works')->onDelete('set null');
            $table->foreignId('stage_id')->nullable()->after('work_stage')->constrained('stages')->onDelete('set null');
            $table->decimal('stage_percentage', 5, 2)->nullable()->after('stage_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_progress', function (Blueprint $table) {
            $table->dropForeign(['work_id']);
            $table->dropForeign(['stage_id']);
            $table->dropColumn(['work_id', 'stage_id', 'stage_percentage']);
        });
    }
};
