<?php

namespace App\Repositories\Api\Admin;

use App\Interfaces\Api\Admin\TaskInterface;
use App\Http\Requests\Task\{StoreRequest, UpdateRequest};
use Illuminate\Support\Facades\DB;
use App\Models\{OnlineClass, Task, User};
use App\Traits\{ResponseBuilder};
use Illuminate\Support\Facades\Log;
use Exception;

class TaskRepository implements TaskInterface
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

            // Checking Role
            if($uid->hasRole(User::ROLE_ADMIN)) return $this->error(403, null, 'Anda Tidak Memiliki Role Admin');

            // List of class and paginate
            $listClass = Task::where('admin_id', $uid->id)->paginate($this->perPage, ['*'], 'page', $this->currentPage);

            return $this->success($listClass);
        } catch (Exception $e) {
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #index');
        }
    }

    public function show(int $id)
    {
        try {
            // Getting the id of user
            $uid = request()->user();

            // Checking Role
            if($uid->hasRole(User::ROLE_ADMIN)) return $this->error(403, null, 'Anda Tidak Memiliki Role Admin');

            // List of class and paginate
            $task = Task::where('admin_id', $uid->id)->where('id', $id)->first();
            if(!$task) return $this->error(404, null, 'Kelas Tidak Ditemukan');

            return $this->success($task);
        } catch (Exception $e) {
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #show');
        }
    }


    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            // Getting the id of user
            $uid = request()->user();

            $user = User::find($uid->id);
            if (!$user) return $this->error(404, null, 'User Tidak Ditemukan');

            $task = OnlineClass::find($request->class_id);
            if (!$task) return $this->error(404, null, 'Kelas Tidak Ditemukan');

            if($user->hasRole(User::ROLE_ADMIN)) return $this->error(403, null, 'Anda Tidak Memiliki Role Admin');

            // Cek Duplikat
            $duplicate = Task::where('title', $request->title)->first();
            if($duplicate) return $this->error(422, null, 'Judul Duplikat');

            $task = new Task;
            $task->admin_id = $user->id;
            $task->title = $request->title; 
            $task->description = $request->description; 
            $task->expired_at = $request->expired_at; 
            $task->save();

            // Save class and the task
            $task->onlineClasses()->attach($request->class_id);

            // Commit
            DB::commit();

            return $this->success($user);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #store Task');
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
            $task = Task::find($id);
            if (!$task) return $this->error(404, null, 'Tugas Tidak Ditemukan');

            // Kepemilikan kelas
            if($task->admin_id !== $user->id) return $this->error(403, null, 'Anda Bukan Pembuat Tugas Ini');

            // Checking Duplicate new name
            if($task->title !== $request->title)
            {
                $duplicate = Task::where('title', $request->title)->first();
                if($duplicate) return $this->error(422, null, 'Judul Tugas Sudah ada');
            }

            $task->title = $request->title; 
            $task->description = $request->description; 
            $task->expired_at = $request->expired_at; 
            $task->save();

            // Commit
            DB::commit();

            return $this->success($user);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #update Task');
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
            $task = Task::find($id);
            if (!$task) return $this->error(404, null, 'Task Tidak Ditemukan');

            // Kepemilikan kelas
            if($task->admin_id !== $user->id) return $this->error(403, null, 'Anda Bukan Pembuat Task Ini');

            // Detach many to many relationship
            $task->onlineClasses()->detach();

            // Delete
            $task->delete();

            // Commit
            DB::commit();

            return $this->success();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #delete Task');
        }
    }

}
