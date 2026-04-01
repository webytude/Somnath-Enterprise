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
            if (!Schema::hasColumn('tool_lists', 'shelf_location')) {
                $table->string('shelf_location')->nullable()->after('location_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tool_lists', function (Blueprint $table) {
            if (Schema::hasColumn('tool_lists', 'shelf_location')) {
                $table->dropColumn('shelf_location');
            }
        });
    }
};

