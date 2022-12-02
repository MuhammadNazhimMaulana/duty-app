<?php

namespace App\Repositories\Api\User;

use App\Interfaces\Api\User\ProfileInterface;
use App\Traits\{ResponseBuilder};
use App\Models\{User, UserProfile, OnlineClass};
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Profile\{StoreRequest, UpdateRequest};
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

            $user = User::find($uid->id);
            if (!$user) return $this->error(404, null, 'Profile Belum Di set');

            // Modifying return value
            $modified = collect([$user])->map(function($item, $key){

                // Adding Avatar and Balance
                return array_merge($item->toArray(), 
                [
                    'profile' => $item->profile,
                    'class' => $item->profile ? $item->profile->onlineClass : 'Belum Ada',
                    'avatar' => $item->avatar
                ]);
            })->collapse();

            return $this->success($modified);
        } catch (Exception $e) {
            return $this->error(400, null, $e->getMessage());
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

            // Finding Class
            $class = OnlineClass::find($request->class_id);
            if(!$class) return $this->error(404, null, 'Kelas Tidak Ditemukan');

            $profile = new UserProfile;
            $profile->user_id = $uid->id;
            $profile->online_class_id = $request->class_id;
            $profile->full_name = $request->full_name;
            $profile->gender = $request->gender;
            $profile->class_name = $class->class_name;
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
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #store profile');
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

            // Finding Class
            $class = OnlineClass::find($request->class_id);
            if(!$class) return $this->error(404, null, 'Kelas Tidak Ditemukan');

            $userProfile->full_name = $request->full_name;
            $userProfile->online_class_id = $request->class_id;
            $userProfile->gender = $request->gender;
            $userProfile->class_name = $class->class_name;
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
            return $this->error(400, null, 'Sepertinya ada yang salah dengan #update profile');
        }
    }

}
