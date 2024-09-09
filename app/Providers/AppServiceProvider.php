<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\FavoriteRepository;
use App\Repositories\BookRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Interfaces\BookRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(FavoriteRepositoryInterface::class, FavoriteRepository::class);
        $this->app->singleton(BookRepositoryInterface::class, BookRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
