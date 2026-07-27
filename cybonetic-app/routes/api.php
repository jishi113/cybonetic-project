<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\StudentApiController;

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::get('health', function () {
        return response()->json(['status' => 'ok', 'timestamp' => now()->toISOString()]);
    });

    // Public Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthApiController::class, 'register']);
        Route::post('login', [AuthApiController::class, 'login']);
    });

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthApiController::class, 'logout']);
        Route::post('auth/logout-all', [AuthApiController::class, 'logoutAll']);
        Route::get('auth/me', [AuthApiController::class, 'me']);

        Route::apiResource('students', StudentApiController::class);
    });
});