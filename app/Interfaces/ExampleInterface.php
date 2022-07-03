<?php

namespace App\Interfaces;

interface ExampleInterface
{
    public function index();

    public function show(int $id);

    public function store();

    public function update(int $id);

    public function delete(int $id);
}
