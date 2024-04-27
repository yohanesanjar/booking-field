<?php

namespace App\Providers;

use App\Models\IndexData;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {
            $data = IndexData::first();
            $view->with('data', $data);
        });
    }
}
