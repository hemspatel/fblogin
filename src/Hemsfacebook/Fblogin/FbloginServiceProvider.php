<?php

namespace Hemsfacebook\Fblogin;

use Illuminate\Support\ServiceProvider;

class FbloginServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('hemsfacebook/fblogin', 'hemsfb');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('hemsfb', function($app) {
            return new Hemsfb();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
