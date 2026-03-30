<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Services\Login\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->loginService->execute($request->validated());
        $user->refresh();
        $request->session()->regenerate();

        return response()->json([
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
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
