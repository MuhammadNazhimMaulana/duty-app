<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\Auth\AuthInterface;

class AuthController extends Controller
{
    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function login()
    {
        return $this->authInterface->login();
    }
}
