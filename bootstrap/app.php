<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e) {
            // 1. Trata erro de autenticação (Garante o status 401)
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Não autenticado.',
                ], 401);
            }

            // 2. Tratamento de validação
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Os dados fornecidos são inválidos.',
                    'errors' => $e->errors(),
                ], 422);
            }

            // 3. Se for uma HttpException conhecida
            if ($e instanceof HttpExceptionInterface) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }

            // 4. Erro genérico (500)
            return response()->json([
                'message' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor.',
            ], 500);
        });
    })->create();
