<?php

namespace App\Http\Controllers\Dashboard;

use App\Exceptions\Auth\ForbiddenException;
use App\Exceptions\Dashboard\DashboardNotFoundException;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAllActiveTeams());
    }

    public function show(string $id): JsonResponse
    {
        $user = Auth::user();

        if (!$user->can("dashboard:{$id}:read")) {
            throw new ForbiddenException('Sem permissão');
        }

        try {
            return response()->json($this->service->getDashboardDataBySlug($id));
        } catch (\Exception $e) {
            throw new DashboardNotFoundException('Dashboard não encontrado.');
        }
    }
}
