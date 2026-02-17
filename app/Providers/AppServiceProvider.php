<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\SeccionMenu;
use App\Observers\SeccionMenuObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SeccionMenu::observe(SeccionMenuObserver::class);
    }
}
