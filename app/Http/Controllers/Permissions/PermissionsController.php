<?php

namespace App\Http\Controllers\Permissions;

use App\Services\Permissions\PermissionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class PermissionsController extends Controller
{
    public function __construct(
        private readonly PermissionsService $permissionsService
    ) {}
    public function getDashboardPermissions(): JsonResponse
    {
        return response()->json($this->permissionsService->getDashboardPermissions(), 200, [], JSON_UNESCAPED_UNICODE);
    }
}
