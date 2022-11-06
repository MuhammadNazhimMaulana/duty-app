<?php

namespace App\Observers;

use App\Models\OnlineClass;
use App\Repositories\Api\User\LogRepository;

class ClassObserver
{
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Handle the onlineClass "created" event.
     *
     * @param  \App\Models\OnlineClass  $onlineClass
     * @return void
     */
    public function created(OnlineClass $onlineClass)
    {
        {
            $this->storeLog('Membuat Kelas #'.$onlineClass->id);   
        } 
    }

    /**
     * Handle the onlineClass "updated" event.
     *
     * @param  \App\Models\OnlineClass  $onlineClass
     * @return void
     */
    public function updated(OnlineClass $onlineClass)
    {
        {
            $this->storeLog('Mengupdate Kelas #'.$onlineClass->id);   
        } 
    }

    /**
     * Handle the onlineClass "deleted" event.
     *
     * @param  \App\Models\OnlineClass  $onlineClass
     * @return void
     */
    public function deleted(OnlineClass $onlineClass)
    {
        {
            $this->storeLog('Menghapus Kelas #'.$onlineClass->id);   
        } 
    }

    // Membuat Log
    protected function storeLog(string $action)
    {
        (new LogRepository)->store($this->user->id, $action);
    }
    
}
