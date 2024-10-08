<?php

namespace App\Providers;

use App\Domains\Books\Repositories\BookAuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookSubjectRepositoryInterface;
use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Infrastructure\Repositories\Books\BookAuthorRepository;
use App\Infrastructure\Repositories\Books\BookSubjectRepository;
use App\Infrastructure\Repositories\Books\SubjectRepository;
use App\Infrastructure\Repositories\Books\AuthorRepository;
use App\Infrastructure\Repositories\Books\BookRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);

        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);

        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);

        $this->app->bind(BookAuthorRepositoryInterface::class, BookAuthorRepository::class);

        $this->app->bind(BookSubjectRepositoryInterface::class, BookSubjectRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
