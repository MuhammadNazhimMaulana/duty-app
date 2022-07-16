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
            // Getting Id
            $uid = request()->user();
            
            // Finding User
            $userLog = UserLog::where('user_id', $uid->id)->orderBy('created_at', 'desc')->paginate($this->perPage, ['*'], 'page', $this->currentPage);
            if (!$userLog) return $this->error(404, null, 'Anda Belum Ada Aktivitas');


            return $this->success($userLog);
        } catch (Exception $e) {
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #index');
        }
    }

    public function store(int $id, string $action)
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
            $log->action = $action;
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
