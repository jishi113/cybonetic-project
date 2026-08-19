<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/leads/trashed', [LeadController::class, 'trashed'])->name('leads.trashed');
    Route::post('/leads/{id}/restore', [LeadController::class, 'restore'])->name('leads.restore');
    Route::patch('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
    Route::resource('leads', LeadController::class);
    Route::resource('companies', CompanyController::class);
});
require __DIR__.'/auth.php';
