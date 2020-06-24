<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Item\ItemRepositoryInterface::class,
            \App\Repositories\Item\ItemRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Cart\CartRepositoryInterface::class,
            \App\Repositories\Cart\CartRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Result\ResultRepositoryInterface::class,
            \App\Repositories\Result\ResultRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Detail\DetailRepositoryInterface::class,
            \App\Repositories\Detail\DetailRepository::class
        );
    }
}
