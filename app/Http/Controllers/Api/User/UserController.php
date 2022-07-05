<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserInterface;
use App\Http\Requests\Profile\{StoreRequest, UpdateeRequest};
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function profile()
    {
        return $this->userInterface->profile();
    }

}
