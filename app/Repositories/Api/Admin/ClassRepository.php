<?php

namespace App\Repositories\Api\Admin;

use App\Interfaces\Api\Admin\ClassInterface;
use App\Http\Requests\ClassOnline\{StoreRequest, UpdateRequest};
use Illuminate\Support\Facades\DB;
use App\Models\{OnlineClass, User};
use App\Traits\{ResponseBuilder};
use Illuminate\Support\Facades\Log;
use Exception;

class ClassRepository implements ClassInterface
{
    use ResponseBuilder;

    public function index()
    {
        try {
            Log::info(request()->header());
            return $this->success();
        } catch (Exception $e) {
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #index');
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

            if($user->hasRole(User::ROLE_ADMIN)) return $this->error(403, null, 'Anda Tidak Memiliki Role Admin');

            // Cek Duplikat
            $duplicate = OnlineClass::where('class_name', $request->class_name)->first();
            if($duplicate) return $this->error(422, null, 'Nama Duplikat');

            $class = new OnlineClass;
            $class->admin_id = $user->id;
            $class->admin_name = $user->name;
            $class->class_name = $request->class_name; 
            $class->save();

            // Commit
            DB::commit();

            return $this->success($user);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #store Class');
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
            $class = OnlineClass::find($id);
            if (!$class) return $this->error(404, null, 'Kelas Tidak Ditemukan');

            // Kepemilikan kelas
            if($class->admin_id !== $user->id) return $this->error(403, null, 'Anda Bukan Pembuat Kelas Ini');

            $class->class_name = $request->class_name; 
            $class->save();

            // Commit
            DB::commit();

            return $this->success($user);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #update Class');
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
            $class = OnlineClass::find($id);
            if (!$class) return $this->error(404, null, 'Kelas Tidak Ditemukan');

            // Kepemilikan kelas
            if($class->admin_id !== $user->id) return $this->error(403, null, 'Anda Bukan Pembuat Kelas Ini');

            // Delete
            $class->delete();

            // Commit
            DB::commit();

            return $this->success();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #delete Class');
        }
    }

}
