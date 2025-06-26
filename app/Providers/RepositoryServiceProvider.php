<?php

namespace App\Providers;

use App\Contract\Repositories\ProductRepositoryInterface;
use App\Contract\Repositories\UserRepositoryInterface;
use App\Contract\Repositories\SaleRepositoryInterface;
use App\Contract\Repositories\JournalRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Repositories\SaleRepository;
use App\Repositories\JournalRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class,ProductRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(JournalRepositoryInterface::class, JournalRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
