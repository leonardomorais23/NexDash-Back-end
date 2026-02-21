<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/sanctum/csrf-cookie', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });
});
