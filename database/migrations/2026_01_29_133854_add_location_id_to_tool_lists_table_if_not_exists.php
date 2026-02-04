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
        Schema::table('tool_lists', function (Blueprint $table) {
            if (!Schema::hasColumn('tool_lists', 'location_id')) {
                $table->foreignId('location_id')->nullable()->after('id')->constrained('locations')->onDelete('set null');
            }
            if (!Schema::hasColumn('tool_lists', 'person_name')) {
                $table->string('person_name')->nullable()->after('location');
            }
            if (!Schema::hasColumn('tool_lists', 'date')) {
                $table->date('date')->nullable()->after('person_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tool_lists', function (Blueprint $table) {
            if (Schema::hasColumn('tool_lists', 'location_id')) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            }
            if (Schema::hasColumn('tool_lists', 'person_name')) {
                $table->dropColumn('person_name');
            }
            if (Schema::hasColumn('tool_lists', 'date')) {
                $table->dropColumn('date');
            }
        });
    }
};
