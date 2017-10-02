<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utility\SortRepository;
use App\Services\ReportingService;

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
        $this->app->singleton(ReportingService::class, function($app) {
            return new ReportingService();
        });
    }
}
