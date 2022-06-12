<?php

namespace Binarycaster\Binarysms\ServiceProviders;

use Illuminate\Support\ServiceProvider;

/**
 * Class BinarysmsServiceProvider
 *
 * @author  Akbar Hossain  <akbarhossain15@gmail.com>
 */
class BinarysmsServiceProvider extends ServiceProvider
{

    /**
     * Boot the package.
     */
    public function boot()
    {
        /*
        |--------------------------------------------------------------------------
        | Publish the Config file from the Package to the App directory
        |--------------------------------------------------------------------------
        */
        $this->configPublisher();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Facade Bindings
        |--------------------------------------------------------------------------
        */
        $this->facadeBindings();
    }

    /**
     * Publish the Config file from the Package to the App directory
     */
    private function configPublisher()
    {
        $this->publishes([
            __DIR__ . '/../Config/binarysms.php' => config_path('binarysms.php'),
        ], 'config');
    }

    /**
     * Facades Binding
     */
    private function facadeBindings()
    {
        $this->app->singleton('BinarysmsManager', function ($app) {
            return new \Binarycaster\Binarysms\BinarysmsManager($app['config']->get('binarysms'));
        });
    }
}
