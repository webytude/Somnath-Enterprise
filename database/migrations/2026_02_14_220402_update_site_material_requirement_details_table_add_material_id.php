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
        Schema::table('site_material_requirement_details', function (Blueprint $table) {
            // Add material_id column
            $table->unsignedBigInteger('material_id')->nullable()->after('site_material_requirement_id');
            $table->foreign('material_id')->references('id')->on('material_lists')->onDelete('set null');
            
            // Remove material_name and rate columns
            $table->dropColumn(['material_name', 'rate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_material_requirement_details', function (Blueprint $table) {
            // Drop foreign key and material_id column
            $table->dropForeign(['material_id']);
            $table->dropColumn('material_id');
            
            // Add back material_name and rate columns
            $table->string('material_name')->after('site_material_requirement_id');
            $table->decimal('rate', 10, 2)->after('unit');
        });
    }
};
