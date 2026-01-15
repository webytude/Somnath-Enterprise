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
            $table->foreignId('location_id')->nullable()->after('id')->constrained('locations')->onDelete('set null');
            $table->string('person_name')->nullable()->after('location');
            $table->date('date')->nullable()->after('person_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tool_lists', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn(['location_id', 'person_name', 'date']);
        });
    }
};
