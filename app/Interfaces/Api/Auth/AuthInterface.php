<?php

namespace App\Interfaces\Api\Auth;

use App\Http\Requests\Auth\{RegisterRequest, LoginRequest, ConfirmResetPasswordRequest};

interface AuthInterface
{
    public function login(LoginRequest $request);

    public function register(RegisterRequest $request);

    public function resetPassword($request);

    public function confirmResetPassword(ConfirmResetPasswordRequest $request);
}
