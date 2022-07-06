<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\ProfileInterface;
use App\Http\Requests\Profile\{StoreRequest, UpdateRequest};
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(ProfileInterface $profileInterface)
    {
        $this->profileInterface = $profileInterface;
    }

    public function profile()
    {
        return $this->profileInterface->profile();
    }

    public function store(StoreRequest $request)
    {
        return $this->profileInterface->store($request);
    }

    public function update(UpdateRequest $request)
    {
        return $this->profileInterface->update($request);
    }

}
