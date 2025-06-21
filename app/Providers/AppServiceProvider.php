<?php

namespace App\Providers;

use App\Repositories\OperatorRepository;
use App\Repositories\OperatorRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
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
        $this->app->bind(OperatorRepositoryInterface::class, OperatorRepository::class);
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
