<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Resources\Settings\UserResource;
use App\Services\Login\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $userModel = $this->loginService->execute($request->validated());

        $user = UserResource::make($userModel)->resolve();

        $request->session()->regenerate();

        $response = response()->json(['user' => $user]);

        return $this->attachAuthCookies($response, $user);
    }

    private function attachAuthCookies(JsonResponse $response, array $user): JsonResponse
    {
        $isProd = config('app.env') === 'production';
        $minutes = 1440;

        return $response
            ->cookie('is_logged_in', 'true', $minutes, '/', null, $isProd, false)
            ->cookie('auth_user', json_encode($user), $minutes, '/', null, $isProd, false);
    }
}
