<?php

namespace App\Observers;

use App\Models\OnlineClass;
use App\Repositories\Api\User\LogRepository;

class ClassObserver
{
    public function __construct()
    {
        $this->user = auth()->user();
    }

    
}
