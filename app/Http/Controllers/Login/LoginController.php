<?php

namespace App\Http\Controllers\Login;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Services\Login\LoginService;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService
    ) {}

    /**
     * @throws InvalidCredentialsException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        $user = $this->loginService->execute($credentials);

        $request->session()->regenerate();

        return response()->json([
            'user' => $user,
        ]);
    }
}
