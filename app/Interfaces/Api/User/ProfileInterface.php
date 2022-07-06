<?php

namespace App\Interfaces\Api\User;
use App\Http\Requests\Profile\{StoreRequest, UpdateRequest};

interface ProfileInterface
{
    public function profile();

    public function store(StoreRequest $request);

    public function update(UpdateRequest $request);
}
