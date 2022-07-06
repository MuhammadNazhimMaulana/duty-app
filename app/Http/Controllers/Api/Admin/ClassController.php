<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\Admin\ClassInterface;
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
}
