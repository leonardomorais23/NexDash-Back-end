<?php

namespace App\Services\Settings;

use App\Http\Requests\Settings\GetUsersRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class SettingsService
{
    public function getUsers(GetUsersRequest $getUsersRequest): Collection
    {
        return User::all();
    }
    public function updateUser(int $id, array $data): void
    {
        $user = User::findOrFail($id);

        $user->update($data);
    }
}
