<?php

namespace App\Observers;

use App\Models\{UserProfile, OnlineClass};
use App\Repositories\Api\User\LogRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
            // Creating Log
            $this->storeteLog('Membuat Profile #'.$userProfile->id);

            // Updating Class
            DB::beginTransaction();
            try {

                // Adding the number of students
                $class = OnlineClass::find($userProfile->online_class_id);
                $class->total_students = $class->total_students + 1;
                $class->save();
                
                DB::commit();
            } catch (Throwable $e) {
                DB::rollback();
                Log::info($e);
            }
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
