<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateDashRequest;
use App\Http\Requests\Dashboard\UpdateDashRequest;
use App\Http\Requests\Dashboard\GetDashRequest;
use App\Http\Requests\User\GetUsersRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Settings\DashResource;
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

    public function updateUser(UpdateUserRequest $updateUserRequest, int $id): AnonymousResourceCollection
    {
        $this->settingsService->updateUser($id, $updateUserRequest->validated());
        return UserResource::collection($this->settingsService->getUsers(new GetUsersRequest()));
    }

    public function getDashboardsTableConfig(GetDashRequest $getDashRequest): AnonymousResourceCollection
    {
        return DashResource::collection($this->dashboardService->getDashboard($getDashRequest));
    }

    public function updateDashboards(UpdateDashRequest $updateDashRequest, int $id): AnonymousResourceCollection
    {
        $this->dashboardService->updateDashboards($id, $updateDashRequest->validated());
        return DashResource::collection($this->dashboardService->getDashboard(new GetDashRequest()));
    }

    public function createDashboard(CreateDashRequest $createDashRequest): AnonymousResourceCollection
    {
        $this->dashboardService->createDashboard($createDashRequest->validated());

        return DashResource::collection($this->dashboardService->getDashboard(new GetDashRequest()));
    }
}
