<?php

namespace App\Interfaces\Api\User;

interface LogInterface
{
    public function index();
    
    public function store(int $id, string $action);

    public function listPdf();
}
