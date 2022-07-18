<?php

namespace App\Observers;

use App\Repositories\Api\User\LogRepository;
use App\Models\{Submission, Task};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
            
            // Updating Class
            DB::beginTransaction();
            try {

                // Adding the number of students
                $class = Task::find($submission->task_id);
                $class->total_collectorss = $class->total_collectorss + 1;
                $class->save();
                
                DB::commit();
            } catch (Throwable $e) {
                DB::rollback();
                Log::info($e);
            }
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
