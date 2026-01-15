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
            $table->foreignId('party_id')->nullable()->after('location_id')->constrained('parties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_materials', function (Blueprint $table) {
            $table->dropForeign(['party_id']);
            $table->dropColumn('party_id');
        });
    }
};
