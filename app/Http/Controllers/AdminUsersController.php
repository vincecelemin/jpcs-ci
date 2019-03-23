<?php

namespace App\Http\Controllers;

use App\Role\UserRole;
use App\User;
use App\UserProfile;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class AdminUsersController extends Controller
{
    public function index()
    {
        $registered_users = [];

        foreach (UserRole::getRoleList() as $role_code => $role) {
            $users = [];
            foreach (User::all() as $user) {
                if ($user->hasRole($role_code)) {
                    $users[] = $user;
                }
            }

            $registered_users[$role_code] = $users;
        }

        $data = [
            'registered_users' => $registered_users,
            'user_roles' => UserRole::getRoleListAndDescription()
        ];

        return view('admin.users')->with($data);
    }

    public function createUser()
    {
        $user_roles = UserRole::getRoleList();

        $data = [
            'user_roles' => $user_roles,
        ];

        return view('admin.users.create')->with($data);
    }

    public function postUser(Request $request)
    {
        $selected_roles = [];
        foreach(UserRole::getRoleList() as $code => $role) {
            if($request->has($code.'check') && $request->input($code.'check') === 'checked')
            $selected_roles [] = $code; 
        }

        if(count($selected_roles) === 0) {
            return redirect()->back()->withInput(Input::all())->with('error', 'Please select at least one role for the user');
        }
        
        $validatedUser = $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mobile_number' => ['required', 'min:11', 'max:15', 'string', 'regex:/^(\b09|\+?639)(\d{9})$/'],
            'tel_number' => ['nullable', 'string', 'regex:/^((\([0-9]{1,5}\)|[0-9]{0,5}){0,1}\s{0,1}([0-9]){3}-([0-9]){4}){0,1}$/'],
            'address' => 'required|string',
            'profile_image' => 'required|file|image|mimes:jpeg,jpg,png',
            'salutation' => 'string',
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->roles = $selected_roles;
        if ($user->save()) {
            // test if image uploaded is uploadable
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fullFileNameToStore = $user->id.'_'.time().'.'.$extension;
            $tmbFileNameToStore = $user->id.'_'.time().'_tmb.'.$extension;
            $profile_image = $request->file('profile_image');
            $image_size_ratio = Image::make($profile_image->getRealPath())->width() / Image::make($profile_image->getRealPath())->height();

            Image::make($profile_image->getRealPath())->save(public_path('storage\\profile_images\\'.$fullFileNameToStore));
            Image::make($profile_image->getRealPath())->resize(200 * $image_size_ratio, 200)->save(public_path('storage\\profile_images\\'.$tmbFileNameToStore));

            $user_profile = new UserProfile();
            $user_profile->user_id = $user->id;
            $user_profile->last_name = trim($request->last_name);
            $user_profile->middle_name = trim($request->middle_name);
            $user_profile->first_name = trim($request->first_name);
            $user_profile->salutation = $request->salutation;
            $user_profile->profile_image = $fullFileNameToStore;
            $user_profile->profile_image_tmb = $tmbFileNameToStore;
            $user_profile->mobile_no = $request->mobile_number;
            $user_profile->tel_no = !$request->tel_number ? '' : $request->tel_number;
            $user_profile->address = $request->address;

            if ($user_profile->save()) {
                return redirect(url('/users'))->with('success', 'New user posted successfully');
            } else {
                $user = User::find($user->id);
                $user->delete();
                return redirect()->back()->with('error', 'Error posting user profile')->withInput(Input::all());
            }
        } else {
            return redirect()->back()->with('error', 'Error posting user account')->withInput(Input::all());
        }
    }

    public function disableUser($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User ID does not exist');
        } else if ($user_id === Auth::user()->id) {
            return redirect()->back()->with('error', 'You cannot disable your own account');
        }

        $user->is_active = 0;
        if ($user->save()) {
            return redirect(url('/users'))->with('success', 'Account disabled successfully');
        } else {
            return redirect()->back()->with('error', 'Unable to disable account');
        }
    }

    public function enableUser($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User ID does not exist');
        } else if ($user_id === Auth::user()->id) {
            return redirect()->back()->with('error', 'You cannot enable your own account');
        }

        $user->is_active = 1;
        if ($user->save()) {
            return redirect(url('/users'))->with('success', 'Account enabled successfully');
        } else {
            return redirect()->back()->with('error', 'Unable to enable account');
        }
    }
}
