<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\Auth\AuthInterface;
use App\Http\Requests\Auth\{RegisterRequest, LoginRequest, ConfirmResetPasswordRequest};
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function login(LoginRequest $request)
    {
        return $this->authInterface->login($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->authInterface->register($request);
    }

    public function resetPassword(Request $request)
    {
        return $this->authInterface->resetPassword($request);
    }

    public function confirmResetPassword(ConfirmResetPasswordRequest $request)
    {
        return $this->authInterface->confirmResetPassword($request);
    }

    public function logout()
    {
        return $this->authInterface->logout();
    }
}
