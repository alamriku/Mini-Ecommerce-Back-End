<?php

namespace App\Providers;

use App\Http\Controllers\Concrete\AdminCollections;
use App\Http\Controllers\Concrete\WebSiteCollections;
use App\Http\Controllers\Interfaces\Collections;
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
        app()->bind(Collections::class,AdminCollections::class);
        app()->bind(Collections::class,WebSiteCollections::class);
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
