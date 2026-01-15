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
        Schema::table('site_materials', function (Blueprint $table) {
            $table->string('gst', 50)->nullable()->after('party_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_materials', function (Blueprint $table) {
            $table->dropColumn('gst');
        });
    }
};
