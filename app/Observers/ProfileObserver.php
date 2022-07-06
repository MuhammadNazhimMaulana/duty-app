<?php

namespace App\Observers;

use App\Models\UserProfile;
use App\Repositories\Api\User\LogRepository;
use Illuminate\Support\Facades\Log;

class ProfileObserver
{
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Handle the userProfile "created" event.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return void
     */
    public function created(UserProfile $userProfile)
    {
        {
            $this->storeteLog('Membuat Profile #'.$userProfile->id);   
        } 
    }

    /**
     * Handle the userProfile "updated" event.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return void
     */
    public function updated(UserProfile $userProfile)
    {
        {
            $this->storeteLog('Mengupdate Profile #'.$userProfile->id);   
        } 
    }

    // Membuat Log
    protected function storeteLog(string $action)
    {
        (new LogRepository)->store($this->user->id, $action);
    }
}
