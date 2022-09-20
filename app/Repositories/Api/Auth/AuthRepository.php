<?php

namespace App\Repositories\Api\Auth;

use App\Interfaces\Api\Auth\AuthInterface;
use App\Traits\{ResponseBuilder};
use App\Models\{User, VerificationCode};
use App\Http\Requests\Auth\{RegisterRequest, LoginRequest, ConfirmResetPasswordRequest};
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Jobs\SendRegisteredEmailJob;
use Illuminate\Support\Facades\Mail;
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

            $body = [
                'title' => 'Berhasil Mendaftar'
            ];

            dispatch(new SendRegisteredEmailJob($body, $register));

            // Commit
            DB::commit();

            return $this->success($register);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan register');
        }
    }

    public function resetPassword($request)
    {
        DB::beginTransaction();
        try {
            // Finding Email
            $user = User::where('email', $request->email)->first();
            if(!$user) return $this->error(404, null, 'Email tidak ditemukan');

            $code = $this->generateUniqueCode();

            $body = [
                'title' => 'Reset Password',
                'code' => $code
            ];

            // Find verfication code
            $vCode = VerificationCode::where('user_id', $user->id)->first();
            
            // Save the verification code
            if ($vCode) {
                if (Carbon::parse($vCode->updated_at)->diffInMinutes(Carbon::now()) >= 1) {
                    $vCode->code = $code;
                    $vCode->expired_at = Carbon::now()->addMinutes(1);
                    $vCode->save();

                    // Send mail
                    Mail::to($user->email)->send(new ForgetPasswordMail($body));
                } else {
                    $code = $vCode->code;

                    // Message, the same code
                    return $this->success('Kode Verifikasi Masih Sama');
                }
            } else {
                $newCode = new VerificationCode();
                $newCode->user_id = $user->id;
                $newCode->code = $code;
                $newCode->expired_at = Carbon::now()->addMinutes(1);
                $newCode->save();

                // Send mail
                Mail::to($user->email)->send(new ForgetPasswordMail($body));
            }

                // Commit
                DB::commit();
            return $this->success();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan Reset Password');
        }        
    }

    public function confirmResetPassword(ConfirmResetPasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            // Today's time
            $now = Carbon::now();

            // Checking Password Confirmation
            if($request->password !== $request->password_confirmation) return $this->error(422, null, 'Password dan Konfirmasi Harus sama');

            // Finding Email
            $user = User::where('email', $request->email)->first();
            if(!$user) return $this->error(404, null, 'Email tidak ditemukan');

            // Find verfication code
            $vCode = VerificationCode::where('user_id', $user->id)->first();

            // Checking expiration time
            if($now->diffInMinutes($vCode->expired_at) > 1) return $this->error(422, null, 'Kode Verifikasi Expired');

            // Chacking the code
            if($request->code != $vCode->code) return $this->error(422, null, 'Kode Verifikasi yang Dimasukkan Salah');

            // If everythingh is good
            $user->password = Hash::make($request->password);
            $user->save();

            // Commit
            DB::commit();
            return $this->success();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Sepertinya ada yang salah dengan Konfrimasi Reset Password');
        }
    }

    public function logout()
    {
        try {
            // Getting Request Sender Information
            $uid = request()->user();

            // Finding User
            $user = User::find($uid->id);

            // Delete Token
            $user->tokens()->delete();
            
            return $this->success();
        } catch (Exception $e) {
            return $this->error(400, null, 'Sepertinya ada yang salah dengan Logout');
        }
    }

    // Unique Code
    private function generateUniqueCode(): string
    {
        return (string) rand(111111, 999999);
    }    
}
