<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\Admin\TaskInterface;
use App\Http\Requests\ClassOnline\{StoreRequest, UpdateRequest};
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(TaskInterface $taskInterface)
    {
        $this->taskInterface = $taskInterface;
    }

    public function index()
    {
        return $this->taskInterface->index();
    }

    public function show(int $id)
    {
        return $this->taskInterface->show($id);
    }

    public function store(StoreRequest $request)
    {
        return $this->taskInterface->store($request);
    }

    public function update(UpdateRequest $request, int $id)
    {
        return $this->taskInterface->update($request, $id);
    }

    public function delete(int $id)
    {
        return $this->taskInterface->delete($id);
    }
}
