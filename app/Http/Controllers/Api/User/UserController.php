<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserInterface;
use App\Http\Requests\Profile\{StoreRequest, UpdateRequest};
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

    public function store(StoreRequest $request)
    {
        return $this->userInterface->store($request);
    }

    public function update(UpdateRequest $request)
    {
        return $this->userInterface->update($request);
    }

}
