<?php

namespace App\Interfaces\Api\User;
use App\Http\Requests\Submission\{StoreRequest, UpdateRequest};

interface SubmissionInterface
{
    public function index();

    public function show(int $id);

    public function store(StoreRequest $request);
    
    public function update(UpdateRequest $request, int $id);

    public function delete(int $id);
}
