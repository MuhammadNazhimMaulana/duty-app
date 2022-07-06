<?php

namespace App\Interfaces\Api\User;
use App\Http\Requests\Profile\{StoreRequest, UpdateeRequest};

interface UserInterface
{
    public function profile();

    public function store(StoreRequest $request);
}
