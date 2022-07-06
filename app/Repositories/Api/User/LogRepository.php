<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\LogInterface;
use App\Traits\{ResponseBuilder};
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
}
