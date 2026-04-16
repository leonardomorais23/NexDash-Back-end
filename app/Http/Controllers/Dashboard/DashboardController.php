<?php

namespace App\Http\Controllers\Dashboard;

use App\Exceptions\Dashboard\DashboardNotFoundException;
use App\Http\Requests\Dashboard\ShowDashboardRequest;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAllActiveTeams());
    }

    public function show(ShowDashboardRequest $_showDashboardRequest, string $slug): JsonResponse
    {
        try {
            return response()->json($this->service->getDashboardDataBySlug($slug));
        } catch (\Exception $e) {
            throw new DashboardNotFoundException('Dashboard [{$slug}] não encontrado.');
        }
    }
}
