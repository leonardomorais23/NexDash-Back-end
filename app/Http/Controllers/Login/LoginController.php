<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Services\Login\LoginService;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService
    )
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->loginService->execute($request->validated());

        $request->session()->regenerate();

        return response()->json([
            'user' => $user,
        ])->cookie(
            'is_logged_in',
            'true',
            config('session.lifetime'),
            '/',
            null,
            config('app.env') === 'production',
            false
        );
    }
}
