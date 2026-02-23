<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterRequest;
use App\Services\Register\RegisterService;
use Illuminate\Http\JsonResponse;


class RegisterController extends Controller
{
    public function __construct(
        private readonly RegisterService $registerService
    ){}
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->registerService->execute(
            $request->validated()
        );

        return response()->json([
            'user' => $user
        ], 201);
    }
}
