<?php

namespace App\Providers;

use App\Providers\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class ExternalAuthApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->provider('externalauthapi',function()
        {
            return new CustomUserProvider();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}