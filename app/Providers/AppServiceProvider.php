<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Services\ArticleService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArticleService::class, function () {
            return new ArticleService(new ArticleRepository());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
    }
}
