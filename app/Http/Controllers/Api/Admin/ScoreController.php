<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\Admin\ScoreInterface;
use App\Http\Requests\Score\{StoreRequest, UpdateRequest};
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function __construct(ScoreInterface $scoreInterface)
    {
        $this->scoreInterface = $scoreInterface;
    }

    public function index()
    {
        return $this->scoreInterface->index();
    }

    public function show(int $id)
    {
        return $this->scoreInterface->show($id);
    }

    public function store(StoreRequest $request)
    {
        return $this->scoreInterface->store($request);
    }

    public function update(UpdateRequest $request, int $id)
    {
        return $this->scoreInterface->update($request, $id);
    }

    public function delete(int $id)
    {
        return $this->scoreInterface->delete($id);
    }
}
