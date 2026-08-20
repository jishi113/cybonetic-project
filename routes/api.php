<?php

use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\LeadApiController;
use App\Http\Controllers\Api\V1\ActivityApiController;
use App\Http\Controllers\Api\V1\DashboardApiController;
use App\Http\Controllers\ExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->name('api.v1.')->group(function () {

    // Auth (public)
    Route::post('/auth/login', [AuthApiController::class, 'login'])->name('auth.login');
    Route::post('/auth/register', [AuthApiController::class, 'register'])->name('auth.register');

    // Protected endpoints
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
        Route::get('/auth/me', [AuthApiController::class, 'me'])->name('auth.me');
        Route::post('/auth/logout', [AuthApiController::class, 'logout'])->name('auth.logout');

        // Leads CRUD
        Route::apiResource('leads', LeadApiController::class);

        // Lead sub-resources
        Route::get('/leads/{lead}/activities', [ActivityApiController::class, 'index'])->name('leads.activities.index');
        Route::post('/leads/{lead}/activities', [ActivityApiController::class, 'store'])->name('leads.activities.store');
        Route::patch('/leads/{lead}/status', [LeadApiController::class, 'updateStatus'])->name('leads.status');

        // Dashboard / Reports
        Route::get('/dashboard/stats', [DashboardApiController::class, 'stats'])->name('dashboard.stats');
        Route::get('/reports/pipeline', [DashboardApiController::class, 'pipeline'])->name('reports.pipeline');
        Route::get('/reports/agents', [DashboardApiController::class, 'agentReport'])->name('reports.agents')->middleware('role:admin,manager');

        // Exports
        Route::get('/exports/leads', [ExportController::class, 'leads'])->name('exports.leads');
    });
});