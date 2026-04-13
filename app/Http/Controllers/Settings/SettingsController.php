<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\GetUsersRequest;
use App\Http\Requests\Settings\UpdateUserRequest;
use App\Http\Resources\Settings\UserTableResource;
use App\Services\Settings\SettingsService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SettingsController extends Controller
{
    public function __construct(
        private readonly SettingsService $settingsService
    ) {}

    public function getUsersTableConfig(GetUsersRequest $settingsRequest): AnonymousResourceCollection
    {
        $users = $this->settingsService->getUsers($settingsRequest);

        return UserTableResource::collection($users);
    }
    public function updateUser(UpdateUserRequest $updateUserRequest, int $id): AnonymousResourceCollection
    {
        $this->settingsService->updateUser($id, $updateUserRequest->validated());

        return $this->getUsersTableConfig(new GetUsersRequest());
    }
}
