<?php

namespace App\Providers;

use App\Http\Repositories\ArticleRepository;
use App\Http\Repositories\DataSourceRepository;
use App\Http\Services\ArticleFetcherService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleFetcherService::class, function ($app){
            $articleRepository = $app->make(ArticleRepository::class);
            $dataSourceRepository = $app->make(DataSourceRepository::class);
            return new ArticleFetcherService($articleRepository, $dataSourceRepository);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
