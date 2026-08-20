<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/test', function () {
        return 'Welcome Admin — you have access.';
    })->name('admin.test');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/leads/trashed', [LeadController::class, 'trashed'])
        ->name('leads.trashed');

    Route::post('/leads/{id}/restore', [LeadController::class, 'restore'])
        ->name('leads.restore');

    Route::patch('/leads/{lead}/status', [LeadController::class, 'updateStatus'])
        ->name('leads.updateStatus');

    Route::resource('leads', LeadController::class);

    Route::resource('companies', CompanyController::class);

    Route::get('/leads-export/csv', [ExportController::class, 'leads'])
        ->name('leads.export');

    Route::post('/leads/{lead}/activities', [ActivityController::class, 'store'])
        ->name('activities.store');

    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])
        ->name('activities.destroy');
});

require __DIR__.'/auth.php';