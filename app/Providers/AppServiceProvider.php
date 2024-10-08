<?php

namespace App\Providers;

use App\Domains\Books\Repositories\LivroRepositoryInterface;
use App\Infrastructure\Repositories\Books\LivroRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LivroRepositoryInterface::class, LivroRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
