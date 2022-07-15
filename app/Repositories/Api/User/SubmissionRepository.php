<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\SubmissionInterface;
use App\Http\Requests\Submission\{StoreRequest, UpdateRequest};
use Illuminate\Support\Facades\DB;
use App\Models\{OnlineClass, Task, User, Submission};
use App\Traits\{ResponseBuilder};
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class SubmissionRepository implements SubmissionInterface
{
    use ResponseBuilder;

    public function __construct()
    {
        // Per Page
        $this->perPage = request()->perPage ?: 20;

        // Current Page
        $this->currentPage = request()->currentPage ?: 1;
    }

    public function index()
    {
        try {
            // Getting the id of user
            $uid = request()->user();

            // List of class and paginate
            $submission = Submission::where('online_class_id', $uid->profile->onlineClass->id)->where('user_id', $uid->id)->paginate($this->perPage, ['*'], 'page', $this->currentPage);

            return $this->success($submission);
        } catch (Exception $e) {
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #index');
        }
    }

    public function show(int $id)
    {
        try {
            // Getting the id of user
            $uid = request()->user();
            
            // List of class and paginate
            $submission = Submission::where('user_id', $uid->id)->where('id', $id)->first();
            if(!$submission) return $this->error(404, null, 'Pengumpulan Tidak Ditemukan');

            // Checking Class
            if($uid->profile->onlineClass->id != $submission->online_class_id) return $this->error(403, null, 'Anda Bukan Bagian Dari Kelas Ini');

            return $this->success($submission);
        } catch (Exception $e) {
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #show');
        }
    }


    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            // Today's time
            $now = Carbon::now();

            // Getting the id of user
            $uid = request()->user();

            $user = User::find($uid->id);
            if (!$user) return $this->error(404, null, 'User Tidak Ditemukan');

            $class = OnlineClass::find($request->class_id);
            if (!$class) return $this->error(404, null, 'Kelas Tidak Ditemukan');

            $task = Task::find($request->task_id);
            if (!$task) return $this->error(404, null, 'Task Tidak Ditemukan');

            $submission = new Submission;
            $submission->online_class_id = $request->class_id;
            $submission->user_id = $user->id;
            $submission->task_id = $request->task_id;
            $submission->task_title = $task->title; 

            // Checking the time
            if($task->expired_at > $now)
            {
                $submission->submission = Submission::LATE; 
            }else{
                $submission->submission = Submission::ONTIME; 
            }

            $submission->save();

            // Commit
            DB::commit();

            return $this->success($submission);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #store Submission');
        }
    }

    public function update(UpdateRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            // Getting the id of user
            $uid = request()->user();

            $user = User::find($uid->id);
            if (!$user) return $this->error(404, null, 'User Tidak Ditemukan');
            
            if($user->hasRole(User::ROLE_ADMIN)) return $this->error(403, null, 'Anda Tidak Memiliki Role Admin');
            
            // Cek Kelas dan admin id
            $submission = Submission::find($id);
            if (!$submission) return $this->error(404, null, 'Tugas Tidak Ditemukan');

            // Kepemilikan kelas
            if($submission->admin_id !== $user->id) return $this->error(403, null, 'Anda Bukan Pembuat Tugas Ini');

            // Checking Duplicate new name
            if($submission->title !== $request->title)
            {
                $duplicate = Submission::where('title', $request->title)->first();
                if($duplicate) return $this->error(422, null, 'Judul Tugas Sudah ada');
            }

            $submission->title = $request->title; 
            $submission->description = $request->description; 
            $submission->expired_at = $request->expired_at; 
            $submission->save();

            // Commit
            DB::commit();

            return $this->success($user);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #update Submission');
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            // Getting the id of user
            $uid = request()->user();

            $user = User::find($uid->id);
            if (!$user) return $this->error(404, null, 'User Tidak Ditemukan');
            
            if($user->hasRole(User::ROLE_ADMIN)) return $this->error(403, null, 'Anda Tidak Memiliki Role Admin');
            
            // Cek Kelas dan admin id
            $submission = Submission::find($id);
            if (!$submission) return $this->error(404, null, 'Submission Tidak Ditemukan');

            // Kepemilikan kelas
            if($submission->admin_id !== $user->id) return $this->error(403, null, 'Anda Bukan Pembuat Submission Ini');

            // Detach many to many relationship
            $submission->onlineClasses()->detach();

            // Delete
            $submission->delete();

            // Commit
            DB::commit();

            return $this->success();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #delete Submission');
        }
    }

}
