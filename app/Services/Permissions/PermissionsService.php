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
}
