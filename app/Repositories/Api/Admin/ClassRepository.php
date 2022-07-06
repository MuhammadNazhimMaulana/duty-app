<?php

namespace App\Repositories\Api\Admin;

use App\Interfaces\Api\Admin\ClassInterface;
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
}
