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
        Schema::table('site_material_requirements', function (Blueprint $table) {
            $table->foreignId('work_id')->nullable()->after('location_id')->constrained('works')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_material_requirements', function (Blueprint $table) {
            $table->dropForeign(['work_id']);
            $table->dropColumn('work_id');
        });
    }
};
