<?php

namespace App\Providers;

use Evelabs\OAuth2\Client\Provider\EveOnline;
use Illuminate\Support\ServiceProvider;

class EveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['Eve'] = $this->app->share(function($app){
            $args = [
                'clientId'          => config('eve.client_id'),
                'clientSecret'      => config('eve.client_secret'),
                'redirectUri'       => config('eve.redirect_uri'),
            ];

            return new EveOnline($args);
        });
    }

    public function provides()
    {
        return ['Eve'];
    }
}