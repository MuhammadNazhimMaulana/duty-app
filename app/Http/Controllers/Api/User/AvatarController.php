<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\AvatarInterface;
use App\Http\Requests\Avatar\{StoreRequest, UpdateRequest};
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function __construct(AvatarInterface $avatarInterface)
    {
        $this->avatarInterface = $avatarInterface;
    }

    public function index()
    {
        return $this->avatarInterface->index();
    }

    public function store(StoreRequest $request)
    {
        return $this->avatarInterface->store($request);
    }

    public function update(UpdateRequest $request)
    {
        return $this->avatarInterface->update($request);
    }
}
