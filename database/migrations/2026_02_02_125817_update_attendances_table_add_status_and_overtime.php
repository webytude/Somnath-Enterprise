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
        Schema::table('attendances', function (Blueprint $table) {
            // Drop the old is_present column
            $table->dropColumn('is_present');
            
            // Add attendance_status enum column
            $table->enum('attendance_status', ['absent', 'present', 'present_with_bike'])->default('absent')->after('attendance_date');
            
            // Add overtime_hours column
            $table->decimal('overtime_hours', 5, 2)->nullable()->default(0)->after('attendance_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['attendance_status', 'overtime_hours']);
            
            // Re-add is_present column
            $table->boolean('is_present')->default(false)->after('attendance_date');
        });
    }
};
