<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Keep works, locations, and divisions when a sub-department is deleted:
     * set subdepartment_id to NULL instead of cascading deletes.
     */
    public function up(): void
    {
        foreach (['works', 'locations', 'divisions'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropForeign(['subdepartment_id']);
            });

            DB::statement("ALTER TABLE `{$table}` MODIFY `subdepartment_id` BIGINT UNSIGNED NULL");

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreign('subdepartment_id')
                    ->references('id')
                    ->on('subdepartments')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Restore CASCADE + NOT NULL (assigns orphaned rows to the first sub-department if any exist).
     */
    public function down(): void
    {
        $fallbackId = DB::table('subdepartments')->orderBy('id')->value('id');

        foreach (['works', 'locations', 'divisions'] as $table) {
            if ($fallbackId !== null) {
                DB::table($table)->whereNull('subdepartment_id')->update(['subdepartment_id' => $fallbackId]);
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropForeign(['subdepartment_id']);
            });

            DB::statement("ALTER TABLE `{$table}` MODIFY `subdepartment_id` BIGINT UNSIGNED NOT NULL");

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreign('subdepartment_id')
                    ->references('id')
                    ->on('subdepartments')
                    ->onDelete('cascade');
            });
        }
    }
};
