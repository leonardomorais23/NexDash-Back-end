<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function index(): JsonResponse
    {
        $dashboards = $this->service->getAllActiveTeams();
        return response()->json($dashboards);
    }

    public function show(string $id): JsonResponse
    {
        $user = Auth::user();

        if (!$user->can("dashboard:{$id}:read")) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        try {
            $data = $this->service->getDashboardDataBySlug($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Dashboard não encontrado'], 404);
        }
    }
}
