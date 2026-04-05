<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * When a department, division, sub-division, location, or work is deleted,
     * referencing rows are kept and the foreign key is set to NULL (where the column is nullable).
     */
    public function up(): void
    {
        $this->alterTableColumns('subdepartments', [
            'department_id' => 'departments',
        ]);

        $this->alterTableColumns('divisions', [
            'department_id' => 'departments',
        ]);

        $this->alterTableColumns('locations', [
            'department_id' => 'departments',
            'division_id' => 'divisions',
            'sub_division_id' => 'sub_divisions',
        ]);

        $this->alterTableColumns('works', [
            'department_id' => 'departments',
            'division_id' => 'divisions',
            'sub_division_id' => 'sub_divisions',
            'location_id' => 'locations',
        ]);

        $this->alterTableColumns('sub_divisions', [
            'division_id' => 'divisions',
        ]);

        $this->alterTableColumns('material_inwards', [
            'location_id' => 'locations',
        ]);

        $this->alterTableColumns('site_material_requirements', [
            'location_id' => 'locations',
        ]);

        $this->alterTableColumns('site_materials', [
            'location_id' => 'locations',
        ]);

        $this->alterTableColumns('work_orders', [
            'location_id' => 'locations',
        ]);

        $this->alterTableColumns('contractor_locations', [
            'location_id' => 'locations',
        ]);

        $this->alterTableColumns('party_locations', [
            'location_id' => 'locations',
        ]);

        $this->alterTableColumns('bill_outward_details', [
            'work_id' => 'works',
        ]);

        $this->alterTableColumns('contractor_works', [
            'work_id' => 'works',
        ]);
    }

    /**
     * @param  array<string, string>  $columnToRefTable  column => referenced table name
     */
    private function alterTableColumns(string $table, array $columnToRefTable): void
    {
        Schema::table($table, function (Blueprint $blueprint) use ($columnToRefTable) {
            foreach (array_keys($columnToRefTable) as $column) {
                $blueprint->dropForeign([$column]);
            }
        });

        foreach ($columnToRefTable as $column => $refTable) {
            if ($this->shouldModifyColumnToNullable($table, $column)) {
                DB::statement("ALTER TABLE `{$table}` MODIFY `{$column}` BIGINT UNSIGNED NULL");
            }
        }

        Schema::table($table, function (Blueprint $blueprint) use ($columnToRefTable) {
            foreach ($columnToRefTable as $column => $refTable) {
                $blueprint->foreign($column)
                    ->references('id')
                    ->on($refTable)
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Skip MODIFY when the column is already nullable (only FK rule changes).
     */
    private function shouldModifyColumnToNullable(string $table, string $column): bool
    {
        $alreadyNullable = [
            'locations.sub_division_id',
            'works.sub_division_id',
            'bill_outward_details.work_id',
        ];

        return ! in_array("{$table}.{$column}", $alreadyNullable, true);
    }

    public function down(): void
    {
        throw new \RuntimeException(
            'This migration is not safely reversible without assigning default parent IDs to NULL rows. Restore from backup if needed.'
        );
    }
};
