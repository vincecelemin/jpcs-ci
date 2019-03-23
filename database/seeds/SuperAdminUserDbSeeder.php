<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserProfile;

class SuperAdminUserDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'pondongbatangan@gmail.com';
        $user->password = bcrypt('password');
        $user->email = 'pondongbatangan@gmail.com';
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->roles = [\App\Role\UserRole::ROLE_ADMIN];

        if($user->save()) {
            $user_profile = new UserProfile;
            $user_profile->user_id = $user->id;
            $user_profile->first_name = 'Manuel';
            $user_profile->middle_name = 'R.';
            $user_profile->last_name = 'Guazon';
            $user_profile->salutation = 'Fr.';
            $user_profile->created_at = date('Y-m-d H:i:s');
            $user_profile->updated_at = date('Y-m-d H:i:s');
            
            if($user_profile->save()) {
            
            } else {
                $user = User::find($user->id);
                $user->delete();
            }
        }
    }
}
