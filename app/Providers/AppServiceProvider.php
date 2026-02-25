<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!App::environment('local')) {
        URL::forceScheme('https');
        }

        Gate::policy(User::class, UserPolicy::class);
        Gate::before(function ($user, $ability) {
        return $user->hasRole('Superadmin') ? true : null;
    });
    }
}
