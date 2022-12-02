<?php

namespace App\Listeners;

use App\Events\LogutActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Api\User\LogRepository;

class StoreUserLogutActivity
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
     * @param  \App\Events\LogutActivity  $event
     * @return void
     */
    public function handle(LogutActivity $event)
    {
        $log = (new LogRepository)->store($event->user->id, 'Logout');

        return $log;
    }
}
