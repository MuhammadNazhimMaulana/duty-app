<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\AvatarInterface;
use App\Traits\{ResponseBuilder};
use App\Models\UserProfile;
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
            return $this->error(400, null, 'Whoops, looks like something went wrong #avatar');
        }
    }

}
