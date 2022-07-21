<?php

namespace App\Providers;

use App\Interfaces\RepositoryInterfaces\BaseRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\OrderRepositoryInterface;
use App\Interfaces\RepositoryInterfaces\ProductRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
