<?php

namespace App\Interfaces\Api\User;
use App\Http\Requests\Avatar\{StoreRequest, UpdateRequest};

interface AvatarInterface
{
    public function index();

    public function store(StoreRequest $request);
}
