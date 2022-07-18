<?php

namespace App\Interfaces\Api\Admin;
use App\Http\Requests\Score\{StoreRequest, UpdateRequest};

interface ScoreInterface
{
    public function index();

    public function show(int $id);

    public function store(StoreRequest $request);
    
    public function update(UpdateRequest $request, int $id);

    public function delete(int $id);
}
