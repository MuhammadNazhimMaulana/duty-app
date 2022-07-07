<?php

namespace App\Observers;

use App\Models\UserAvatar;
use App\Repositories\Api\User\LogRepository;
use Illuminate\Support\Facades\Log;

class AvatarObserver
{
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Handle the userProfile "created" event.
     *
     * @param  \App\Models\UserAvatar  $userAvatar
     * @return void
     */
    public function created(UserAvatar $userAvatar)
    {
        {
            $this->storeteLog('Membuat Avatar #'.$userAvatar->id);   
        } 
    }

    /**
     * Handle the userProfile "updated" event.
     *
     * @param  \App\Models\UserAvatar  $userAvatar
     * @return void
     */
    public function updated(UserAvatar $userAvatar)
    {
        {
            $this->storeteLog('Mengupdate Avatar #'.$userAvatar->id);   
        } 
    }

    // Membuat Log
    protected function storeteLog(string $action)
    {
        (new LogRepository)->store($this->user->id, $action);
    }
}
