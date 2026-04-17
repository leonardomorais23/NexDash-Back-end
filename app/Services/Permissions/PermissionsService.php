<?php

namespace App\Services\Permissions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsService
{
    public function getDashboardPermissions(): Collection
    {
        return Permission::where('name', 'like', 'dashboard:%')->get()->map(fn($perm) => [
            'id'    => $perm->name,
            'label' => Str::of($perm->name)
                ->replace(['dashboard:', ':read'], '')
                ->replace('-', ' ')
                ->squish()
                ->title()
        ]);
    }
    public function updateDashboardPermission(string $oldSlug, string $newSlug): void
    {
        $oldName = "dashboard:{$oldSlug}:read";
        $newName = "dashboard:{$newSlug}:read";

        Permission::where('name', $oldName)
            ->where('guard_name', 'api')
            ->update(['name' => $newName]);

        Permission::firstOrCreate(['name' => $newName, 'guard_name' => 'api']);
    }

    public function createPermission(string $slug, array $roleNames): void
    {
        $permission = Permission::create([
            'name' => "dashboard:{$slug}:read",
            'guard_name' => 'api'
        ]);

        if (!empty($roleNames)) {
            $roles = Role::whereIn('name', $roleNames)->get();
            foreach ($roles as $role) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
