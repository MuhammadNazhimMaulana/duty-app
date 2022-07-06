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

        // User Profile
        $this->app->bind(
            'App\Interfaces\Api\User\ProfileInterface',
            'App\Repositories\Api\User\ProfileRepository'
        );
        
        // User Avatar
        $this->app->bind(
            'App\Interfaces\Api\User\AvatarInterface',
            'App\Repositories\Api\User\AvatarRepository'
        );
        
        // User Log
        $this->app->bind(
            'App\Interfaces\Api\User\LogInterface',
            'App\Repositories\Api\User\LogRepository'
        );
        
        // Class
        $this->app->bind(
            'App\Interfaces\Api\Admin\ClassInterface',
            'App\Repositories\Api\Admin\ClassRepository'
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
