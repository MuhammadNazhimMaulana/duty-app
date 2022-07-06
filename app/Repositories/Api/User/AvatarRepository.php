<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\AvatarInterface;
use App\Traits\{ResponseBuilder};
use App\Models\UserAvatar;
use App\Http\Requests\Avatar\{StoreRequest, UpdateRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class AvatarRepository implements AvatarInterface
{
    use ResponseBuilder;

    public function index()
    {
        try {
            // Getting the id of user
            $uid = request()->user();

            return $this->success($uid);
        } catch (Exception $e) {
            return $this->error(400, null, 'Ada yang salah dengan #avatar');
        }
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            // Getting the id of user
            $uid = request()->user();

            $userAvatar = UserAvatar::where('user_id', $uid->id)->first();
            if ($userAvatar) return $this->error(404, null, 'Store Profile Hanya Sekali');

            $avatar = new UserAvatar;
            $avatar->user_id = $uid->id;

            // Checking Avatar
            if ($request->file('avatar')) {
                $avatar->picture_path = $request->file('avatar')->store('Avatar');
            }

            $avatar->save();

            // Commit
            DB::commit();

            return $this->success($avatar);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Ada yang salah dengan #store avatar');
        }
    }
}
