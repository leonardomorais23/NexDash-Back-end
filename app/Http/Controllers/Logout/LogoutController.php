<?php
namespace App\Http\Controllers\Logout;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Logout\LogoutService;
use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    public function __construct(
        private readonly LogoutService $logoutService
    ) {}
    public function logout(Request $request): JsonResponse
    {
        $this->logoutService->execute();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ], 200)->withCookie(
            Cookie::forget('is_logged_in')
        );
    }
}
