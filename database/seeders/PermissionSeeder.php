<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Permission names follow Laravel-style route names, e.g. staff.index, staff.show, staff.edit.
     * Use the same string in middleware: ->middleware('permission:staff.index')
     * and Blade: @hasPermission('staff.index')
     */
    public function run(): void
    {
        $rows = [];

        $this->pushNamed($rows, 'admin.dashboard', 'dashboard', 'dashboard');

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "users.{$action}", 'users', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "departments.{$action}", 'departments', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "sub-departments.{$action}", 'sub-departments', $action);
        }

        $this->pushNamed($rows, 'division.getSubdepartments', 'division', 'getSubdepartments');
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "division.{$action}", 'division', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "sub-division.{$action}", 'sub-division', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "pedhi.{$action}", 'pedhi', $action);
        }

        foreach (['getSubdepartments', 'getDivisions', 'getSubDivisions'] as $suffix) {
            $this->pushNamed($rows, "locations.{$suffix}", 'locations', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "locations.{$action}", 'locations', $action);
        }

        foreach (['getSubdepartments', 'getDivisions', 'getSubDivisions', 'getLocations'] as $suffix) {
            $this->pushNamed($rows, "works.{$suffix}", 'works', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "works.{$action}", 'works', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "firms.{$action}", 'firms', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "staff.{$action}", 'staff', $action);
        }

        foreach (['index', 'update', 'get', 'report'] as $action) {
            $this->pushNamed($rows, "attendance.{$action}", 'attendance', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "daily-expense.{$action}", 'daily-expense', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "parties.{$action}", 'parties', $action);
        }

        $this->pushNamed($rows, 'contractors.getWorksByLocations', 'contractors', 'getWorksByLocations');
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "contractors.{$action}", 'contractors', $action);
        }

        foreach (['getWorksByLocation', 'getStagesByWork'] as $suffix) {
            $this->pushNamed($rows, "site-progress.{$suffix}", 'site-progress', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "site-progress.{$action}", 'site-progress', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "tool-lists.{$action}", 'tool-lists', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "scrap-materials.{$action}", 'scrap-materials', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "scrap-lists.{$action}", 'scrap-lists', $action);
        }

        foreach (['getMaterialsByCategory', 'getWorksByLocation'] as $suffix) {
            $this->pushNamed($rows, "site-material-requirements.{$suffix}", 'site-material-requirements', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "site-material-requirements.{$action}", 'site-material-requirements', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "material-categories.{$action}", 'material-categories', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "material-lists.{$action}", 'material-lists', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "stages.{$action}", 'stages', $action);
        }

        foreach (['getPartyDetails', 'getWorksByLocation', 'getPartiesByLocation', 'getMaterialsByParty'] as $suffix) {
            $this->pushNamed($rows, "material-inwards.{$suffix}", 'material-inwards', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "material-inwards.{$action}", 'material-inwards', $action);
        }

        foreach (['getPartyDetails', 'getMaterialsByParty'] as $suffix) {
            $this->pushNamed($rows, "bill-inwards.{$suffix}", 'bill-inwards', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "bill-inwards.{$action}", 'bill-inwards', $action);
        }

        foreach (['getPartyDetails', 'getMaterialsByParty', 'getWorksByParty'] as $suffix) {
            $this->pushNamed($rows, "bill-outwards.{$suffix}", 'bill-outwards', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "bill-outwards.{$action}", 'bill-outwards', $action);
        }

        foreach (['getStaffPayable', 'getPartyBills', 'getPartyMaterialInwards', 'getVendorBills'] as $suffix) {
            $this->pushNamed($rows, "payments.{$suffix}", 'payments', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "payments.{$action}", 'payments', $action);
        }

        foreach (['previewNumber', 'vendorAssignments'] as $suffix) {
            $this->pushNamed($rows, "work-orders.{$suffix}", 'work-orders', $suffix);
        }
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "work-orders.{$action}", 'work-orders', $action);
        }

        foreach (['getProfile', 'editProfile', 'updateProfile', 'changePassword', 'updatePassword'] as $suffix) {
            $this->pushNamed($rows, "user.{$suffix}", 'profile', $suffix);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "gst-bill-lists.{$action}", 'gst-bill-lists', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "payment-slabs.{$action}", 'payment-slabs', $action);
        }

        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $action) {
            $this->pushNamed($rows, "roles.{$action}", 'roles', $action);
        }

        $this->pushNamed($rows, 'permissions.index', 'permissions', 'index');

        foreach ($rows as $row) {
            Permission::updateOrCreate(
                ['name' => $row['name']],
                ['module' => $row['module'], 'action' => $row['action']]
            );
        }
    }

    private function pushNamed(array &$rows, string $name, string $module, string $action): void
    {
        $rows[] = [
            'name' => $name,
            'module' => $module,
            'action' => $action,
        ];
    }
}
