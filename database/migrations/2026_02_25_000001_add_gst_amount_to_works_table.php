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
        Schema::table('works', function (Blueprint $table) {
            // GST percentage already stored in add_18_percent_gst (rename meaning to GST %)
            // New column will store calculated GST amount
            $table->decimal('gst_amount', 15, 2)->nullable()->after('add_18_percent_gst');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('gst_amount');
        });
    }
};

