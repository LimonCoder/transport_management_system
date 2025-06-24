<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Repositories\DriverRepository;
use App\Repositories\DriverRepositoryInterface;
use App\Repositories\OperatorRepository;
use App\Repositories\OperatorRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OperatorRepositoryInterface::class, OperatorRepository::class);
        $this->app->bind(DriverRepositoryInterface::class, DriverRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::setLocale(Session::get('locale', config('app.locale')));
    }
}
