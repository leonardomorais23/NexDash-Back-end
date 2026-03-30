<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Logout\LogoutController;
use App\Http\Controllers\Register\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class . '@login');
Route::post('Register', RegisterController::class . '@register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();

        return response()->json([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    });
    Route::post('/logout', LogoutController::class . '@logout');

    Route::prefix('dashboard')->group(function () {
        Route::get('/modules', [DashboardController::class, 'index']);
        Route::get('/{id}', [DashboardController::class, 'show']);
    });
});
