<?php

namespace App\Observers;

use App\Repositories\Api\User\LogRepository;
use App\Models\{Submission, Task};

class SubmissionObserver
{
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Handle the submission "created" event.
     *
     * @param  \App\Models\Submission  $submission
     * @return void
     */
    public function created(Submission $submission)
    {
        {
            $this->storeteLog('Membuat Pengumpulan #'.$submission->id);   
        } 
    }

    /**
     * Handle the submission "updated" event.
     *
     * @param  \App\Models\Submission  $submission
     * @return void
     */
    public function updated(Submission $submission)
    {
        {
            $this->storeteLog('Mengupdate Pengumpulan #'.$submission->id);   
        } 
    }

    /**
     * Handle the submission "deleted" event.
     *
     * @param  \App\Models\Submission  $submission
     * @return void
     */
    public function deleted(Submission $submission)
    {
        {
            $this->storeteLog('Menghapus Pengumpulan #'.$submission->id);   
        } 
    }

    // Membuat Log
    protected function storeteLog(string $action)
    {
        (new LogRepository)->store($this->user->id, $action);
    }
}
