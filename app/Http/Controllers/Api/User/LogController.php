<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\LogInterface;

class LogController extends Controller
{
    public function __construct(LogInterface $logInterface)
    {
        $this->logInterface = $logInterface;
    }

    public function index()
    {
        return $this->logInterface->index();
    }

    public function listPdf()
    {
        return $this->logInterface->listPdf();
    }
}
