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
        Schema::table('stages', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('percentage')->constrained('locations')->onDelete('set null');
            $table->foreignId('work_id')->nullable()->after('location_id')->constrained('works')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropForeign(['work_id']);
            $table->dropColumn(['location_id', 'work_id']);
        });
    }
};

