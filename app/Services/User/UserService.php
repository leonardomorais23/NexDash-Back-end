<?php

namespace App\Services\User;

use App\Http\Requests\User\GetUsersRequest;
use App\Models\User;
use Illuminate\Support\Collection;

class UserService
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
}
