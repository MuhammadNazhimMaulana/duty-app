<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\Admin\ClassInterface;
use App\Http\Requests\ClassOnline\{StoreRequest, UpdateRequest};
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct(ClassInterface $classIneterface)
    {
        $this->classIneterface = $classIneterface;
    }

    public function index()
    {
        return $this->classIneterface->index();
    }

    public function show(int $id)
    {
        return $this->classIneterface->show($id);
    }

    public function store(StoreRequest $request)
    {
        return $this->classIneterface->store($request);
    }

    public function update(UpdateRequest $request, int $id)
    {
        return $this->classIneterface->update($request, $id);
    }

    public function delete(int $id)
    {
        return $this->classIneterface->delete($id);
    }
}
