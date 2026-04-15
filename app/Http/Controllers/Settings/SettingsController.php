<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\GetUsersRequest;
use App\Http\Requests\Settings\UpdateUserRequest;
use App\Http\Resources\Settings\UserTableResource;
use App\Services\Settings\SettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\Permission\Models\Permission;

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
    public function updateUser(UpdateUserRequest $updateUserRequest, int $id)
    {
        $this->settingsService->updateUser($id, $updateUserRequest->validated());

        return UserTableResource::collection($this->settingsService->getUsers(new GetUsersRequest()));
    }
    public function getAllPermissions(): JsonResponse
    {
        return response()->json($this->settingsService->getDashboardPermissions(), 200, [], JSON_UNESCAPED_UNICODE);
    }
}
