<?php

namespace App\Providers;

use App\Repositories\Building\BuildingRepository;
use App\Repositories\Building\BuildingRepositoryInterface;
use App\Repositories\QrCode\QrCodeRepository;
use App\Repositories\QrCode\QrCodeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            BuildingRepositoryInterface::class,
            BuildingRepository::class
        );
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->singleton(
            QrCodeRepositoryInterface::class,
            QrCodeRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
