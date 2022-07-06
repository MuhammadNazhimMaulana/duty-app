<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\ProfileInterface;
use App\Traits\{ResponseBuilder};
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Profile\{StoreRequest, UpdateRequest};
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class ProfileRepository implements ProfileInterface
{
    use ResponseBuilder;

    public function profile()
    {
        try {
            // Getting the id of user
            $uid = request()->user();

            $userProfile = UserProfile::where('user_id', $uid->id)->first();
            if (!$userProfile) return $this->error(404, null, 'Profile Belum Di set');

            return $this->success($userProfile);
        } catch (Exception $e) {
            return $this->error(400, null, 'Whoops, looks like something went wrong #profile');
        }
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {

            // Today's time
            $now = Carbon::now();

            // Getting the id of user
            $uid = request()->user();

            $userProfile = UserProfile::where('user_id', $uid->id)->first();
            if ($userProfile) return $this->error(404, null, 'Store Profile Hanya Sekali');

            $profile = new UserProfile;
            $profile->user_id = $uid->id;
            $profile->full_name = $request->full_name;
            $profile->gender = $request->gender;
            $profile->class = $request->class;
            $profile->hobby = $request->hobby;
            $profile->address = $request->address;
            $profile->date_of_birth = $request->date_of_birth;
            
            // Getting age based on fate of birth
            $profile->age = $now->diffInYears($request->date_of_birth);
            $profile->save();

            // Commit
            DB::commit();

            return $this->success($profile);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Whoops, looks like something went wrong #store profile');
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {

            // Today's time
            $now = Carbon::now();

            // Getting the id of user
            $uid = request()->user();

            // Finding Profile
            $userProfile = UserProfile::where('user_id', $uid->id)->first();
            if (!$userProfile) return $this->error(404, null, 'Profile Belum di Set');

            
            $userProfile->full_name = $request->full_name;
            $userProfile->gender = $request->gender;
            $userProfile->class = $request->class;
            $userProfile->hobby = $request->hobby;
            $userProfile->address = $request->address;
            $userProfile->date_of_birth = $request->date_of_birth;
            
            // Getting age based on fate of birth
            $userProfile->age = $now->diffInYears($request->date_of_birth);
            $userProfile->save();

            // Commit
            DB::commit();

            return $this->success($userProfile);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(400, null, 'Whoops, looks like something went wrong #update profile');
        }
    }

}