<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\GetDashRequest;
use App\Http\Requests\User\GetUsersRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Settings\DashTableResource;
use App\Http\Resources\Settings\UserResource;
use App\Services\Dashboard\DashboardService;
use App\Services\User\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SettingsController extends Controller
{
    public function __construct(
        private readonly UserService      $settingsService,
        private readonly DashboardService $dashboardService
    ) {}

    public function getUsersTableConfig(GetUsersRequest $getUsersRequest): AnonymousResourceCollection
    {
        return UserResource::collection($this->settingsService->getUsers($getUsersRequest));
    }

    public function updateUser(UpdateUserRequest $updateUserRequest, int $id)
    {
        $this->settingsService->updateUser($id, $updateUserRequest->validated());

        return UserResource::collection($this->settingsService->getUsers(new GetUsersRequest()));
    }

    public function getDashboardsTableConfig(GetDashRequest $getDashRequest): AnonymousResourceCollection
    {
        return DashTableResource::collection($this->dashboardService->getDashboard($getDashRequest));
    }
}
