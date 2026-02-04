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
        Schema::table('staff', function (Blueprint $table) {
            $table->decimal('rate_per_day', 10, 2)->nullable()->after('remark');
            $table->decimal('rate_per_month', 10, 2)->nullable()->after('rate_per_day');
            $table->date('salary_date')->nullable()->after('rate_per_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['rate_per_day', 'rate_per_month', 'salary_date']);
        });
    }
};
