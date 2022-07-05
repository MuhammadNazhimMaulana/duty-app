<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\UserInterface;
use App\Traits\{ResponseBuilder};
use Illuminate\Support\Facades\Log;
use Exception;

class UserRepository implements UserInterface
{
    use ResponseBuilder;

    public function profile()
    {
        try {
            Log::info(request()->header());
            return $this->success();
        } catch (Exception $e) {
            return $this->error(400, null, 'Whoops, looks like something went wrong #index');
        }
    }

}
