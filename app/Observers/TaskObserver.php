<?php

namespace App\Observers;

use App\Repositories\Api\User\LogRepository;
use App\Models\Task;

class TaskObserver
{
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Handle the task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        {
            $this->storeteLog('Membuat Tugas #'.$task->id);   
        } 
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        {
            $this->storeteLog('Mengupdate Tugas #'.$task->id);   
        } 
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        {
            $this->storeteLog('Menghapus Tugas #'.$task->id);   
        } 
    }

    // Membuat Log
    protected function storeteLog(string $action)
    {
        (new LogRepository)->store($this->user->id, $action);
    }
}
