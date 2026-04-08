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
        $userModel = $this->loginService->execute($request->validated());

        $user = [
            'id'          => $userModel->id,
            'name'        => $userModel->name,
            'email'       => $userModel->email,
            'roles'       => $userModel->getRoleNames(),
            'permissions' => $userModel->getAllPermissions()->pluck('name'),
        ];

        $request->session()->regenerate();

        return response()->json(['user' => $user])
            ->cookie('is_logged_in', 'true', 1440, '/', null, config('app.env') === 'production', false)
            ->cookie('auth_user', json_encode($user), 1440, '/', null, config('app.env') === 'production', false);
    }
}
