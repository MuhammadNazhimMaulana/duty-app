<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\SubmissionInterface;
use App\Http\Requests\Submission\{StoreRequest, UpdateRequest};
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __construct(SubmissionInterface $submissionInterface)
    {
        $this->submissionInterface = $submissionInterface;
    }

    public function index()
    {
        return $this->submissionInterface->index();
    }

    public function show(int $id)
    {
        return $this->submissionInterface->show($id);
    }

    public function store(StoreRequest $request)
    {
        return $this->submissionInterface->store($request);
    }

    public function update(UpdateRequest $request, int $id)
    {
        return $this->submissionInterface->update($request, $id);
    }

    public function delete(int $id)
    {
        return $this->submissionInterface->delete($id);
    }
}
