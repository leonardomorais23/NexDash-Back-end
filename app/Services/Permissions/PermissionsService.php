<?php

namespace App\Services\Permissions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

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
}
