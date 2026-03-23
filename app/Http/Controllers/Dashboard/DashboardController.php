<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $service
    ) {}
    public function index(): JsonResponse
    {
        return response()->json($this->service->getAllActiveTeams());
    }

    public function show(string $id): JsonResponse
    {
        try {
            $data = $this->service->getDashboardDataBySlug($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Dashboard não encontrado'], 404);
        }
    }
}
