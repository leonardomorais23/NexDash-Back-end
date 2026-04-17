<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Logout\LogoutController;
use App\Http\Controllers\Permissions\PermissionsController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Resources\Settings\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return UserResource::make($request->user());
    });

    Route::post('/logout', [LogoutController::class, 'logout']);

    Route::get('/permissions', [PermissionsController::class, 'getDashboardPermissions']);

    Route::prefix('dashboard')->group(function () {
        Route::get('/modules', [DashboardController::class, 'index']);
        Route::get('/{slug}', [DashboardController::class, 'show']);
    });

    Route::prefix('settings')->group(function () {
        Route::get('/users', [SettingsController::class, 'getUsersTableConfig']);
        Route::get('/dashboards', [SettingsController::class, 'getDashboardsTableConfig']);
        Route::patch('/dashboards/{id}', [SettingsController::class, 'updateDashboards']);
        Route::patch('/users/{id}', [SettingsController::class, 'updateUser']);
    });
});
