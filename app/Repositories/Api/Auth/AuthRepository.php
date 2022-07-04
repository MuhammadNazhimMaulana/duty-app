<?php

namespace App\Repositories\Api\Auth;

use App\Interfaces\Api\Auth\AuthInterface;
use App\Traits\{ResponseBuilder};
use App\Models\{User, VerificationCode};
use App\Http\Requests\Auth\{RegisterRequest, LoginRequest, ConfirmResetPasswordRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthRepository implements AuthInterface
{
    use ResponseBuilder;

    public function login(LoginRequest $request)
    {
        try {

            // Finding User
            $user = User::where('email', $request->email)->first();

            // Checking Password Confirmation
            if($request->password !== $request->password_confirmation) return $this->error(422, null, 'Password dan Konfirmasi Harus sama');
            
            // Checking Input Password and saved password
            if( !$user || !Hash::check($request->password, $user->password)) return $this->error(422, null, 'Email atau Password salah');
            
            // In case there is a token delete old token
            $user->tokens()->delete();

            // If there is no issue
            $token = $user->createToken($user->name)->plainTextToken;

            // Shwoing Token
            $user->token = $token;

            return $this->success($user);
        } catch (Exception $e) {
            // $this->report($e);

            return $this->error(400, null, 'Sepertinya ada yang salah dengan Login');
        }
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            // Checking Duplicate Email
            $duplicate = User::where('email', $request->email)->first();
            if($duplicate) return $this->error(422, null, 'Email Sudah ada Sebelumnya');
            
            // Checking Password Confirmation
            if($request->password !== $request->password_confirmation) return $this->error(422, null, 'Password dan Konfirmasi Harus sama');

            // Registering Data
            $register = new User;
            $register->name = $request->name;
            $register->email = $request->email;
            $register->password = Hash::make($request->password);
            $register->phone = $request->phone;
            $register->save();

            // Assigning Role
            $register->assignRole(User::ROLE_USER);
            
            // Commit
            DB::commit();

            return $this->success($register);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan register');
        }
    }
}
