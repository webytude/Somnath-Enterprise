<?php

namespace App\Traits;

use App\Models\Role;

trait HasRolePermissions
{
    public function hasPermission(string $permissionName): bool
    {
        if (!$this->role_id) {
            return false;
        }

        $this->loadMissing('role');

        if (!$this->role) {
            return false;
        }

        if (strcasecmp((string) $this->role->name, Role::ADMIN) === 0) {
            return true;
        }

        return $this->role->permissions()->where('name', $permissionName)->exists();
    }

    public function hasRole(string $roleName): bool
    {
        $this->loadMissing('role');

        return (bool) ($this->role && strcasecmp((string) $this->role->name, $roleName) === 0);
    }
}
