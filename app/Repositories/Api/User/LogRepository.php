<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\LogInterface;
use App\Traits\{ResponseBuilder};
use Illuminate\Support\Facades\DB;
use App\Models\{User, UserLog};
use Illuminate\Support\Facades\Log;
use Exception;

class LogRepository implements LogInterface
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

    public function store(int $id, $request)
    {
        DB::beginTransaction();
        try {

            $user = User::find($id);
            if(!$user) return $this->error(404, null, 'User Tidak Ditemukan');

            // New Log
            $log = new UserLog;
            $log->user_id = $user->id;
            $log->user_name = $user->name;
            $log->user_email = $user->email;
            $log->action = $request->action;
            $log->save();

            // Commit
            DB::commit();

            return $this->success($log);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #store log');
        }
    }
}
