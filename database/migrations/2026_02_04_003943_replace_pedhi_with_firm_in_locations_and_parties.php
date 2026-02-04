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
        // Update locations table
        Schema::table('locations', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['pedhi_id']);
            // Rename column
            $table->renameColumn('pedhi_id', 'firm_id');
        });
        
        // Re-add foreign key with new name
        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('firm_id')->references('id')->on('firms')->onDelete('cascade');
        });
        
        // Update parties table
        Schema::table('parties', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['pedhi_id']);
            // Rename column
            $table->renameColumn('pedhi_id', 'firm_id');
        });
        
        // Re-add foreign key with new name
        Schema::table('parties', function (Blueprint $table) {
            $table->foreign('firm_id')->references('id')->on('firms')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert parties table
        Schema::table('parties', function (Blueprint $table) {
            $table->dropForeign(['firm_id']);
            $table->renameColumn('firm_id', 'pedhi_id');
        });
        
        Schema::table('parties', function (Blueprint $table) {
            $table->foreign('pedhi_id')->references('id')->on('pedhi')->onDelete('set null');
        });
        
        // Revert locations table
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['firm_id']);
            $table->renameColumn('firm_id', 'pedhi_id');
        });
        
        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('pedhi_id')->references('id')->on('pedhi')->onDelete('cascade');
        });
    }
};
