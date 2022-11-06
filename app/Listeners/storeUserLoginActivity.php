<?php

namespace App\Listeners;

use App\Events\LoginActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Api\User\LogRepository;

class storeUserLoginActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LoginActivity  $event
     * @return void
     */
    public function handle(LoginActivity $event)
    {
        $log = (new LogRepository)->store($event->user->id, 'Login');

        return $log;
    }
}
