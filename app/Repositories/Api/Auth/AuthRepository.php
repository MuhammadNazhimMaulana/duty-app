<?php

namespace App\Repositories\Api\Auth;

use App\Interfaces\Api\Auth\AuthInterface;
use App\Traits\{ResponseBuilder};
use Illuminate\Support\Facades\Log;
use Exception;

class AuthRepository implements AuthInterface
{
    use ResponseBuilder;

    public function login()
    {
        try {
            // Log::info(request()->header());

            return $this->success('jalan');
        } catch (Exception $e) {
            // $this->report($e);

            return $this->error(400, null, 'Whoops, looks like something went wrong #index');
        }
    }
}
