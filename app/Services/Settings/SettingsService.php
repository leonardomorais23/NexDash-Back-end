<?php

namespace App\Services\Settings;

use App\Http\Requests\Settings\GetUsersRequest;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class SettingsService
{
    public function getUsers(GetUsersRequest $getUsersRequest): Collection
    {
        return User::all();
    }
    public function updateUser(int $id, array $data): void
    {
        $user = User::findOrFail($id);

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        if (array_key_exists('roles', $data)) {
            $user->syncRoles(array_filter((array)$data['roles']));
        }

        if (array_key_exists('permissions', $data)) {
            $user->syncPermissions(array_filter((array)$data['permissions']));
        }
    }
    public function getDashboardPermissions(): Collection
    {
        return Permission::all()->map(function ($perm) {
            $cleanLabel = str_replace(['dashboard:', ':read'], '', $perm->name);
            $cleanLabel = str_replace('-', ' ', $cleanLabel);
            $cleanLabel = preg_replace('/\s+/', ' ', $cleanLabel);

            return [
                'id'    => $perm->name,
                'label' => mb_convert_case(trim($cleanLabel), MB_CASE_TITLE, "UTF-8")
            ];
        });
    }
}
