<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(
        //     'App\Interfaces\ExampleInterface',
        //     'App\Repositories\ExampleRepository'
        // );

        // Auth
        $this->app->bind(
            'App\Interfaces\Api\Auth\AuthInterface',
            'App\Repositories\Api\Auth\AuthRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
