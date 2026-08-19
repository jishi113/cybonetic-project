<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('access-admin-panel', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('export-reports', function (User $user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('view-salary-data', function (User $user) {
            return in_array($user->role, ['admin', 'hr']);
        });
    }
}