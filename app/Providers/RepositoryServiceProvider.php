<?php

namespace App\Providers;

use App\Http\Repositories\ArticleRepository;
use App\Http\Repositories\DataSourceRepository;
use App\Http\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Http\Repositories\Interfaces\DataSourceRepositoryInterface;
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
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(DataSourceRepositoryInterface::class, DataSourceRepository::class);

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
