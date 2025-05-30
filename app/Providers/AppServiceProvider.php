<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\{
    UserService,
    UserServiceInterface,
    ActivityLogService,
    ActivityLogServiceInterface,
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ActivityLogServiceInterface::class, ActivityLogService::class);
    }
}
