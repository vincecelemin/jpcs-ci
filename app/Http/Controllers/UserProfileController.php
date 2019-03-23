<?php

namespace App\Http\Controllers;

use App\Role\UserRole;
use App\User;
use App\UserProfile;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Validator;

class UserProfileController extends Controller
{
    public function index($user_profile_id = '')
    {
        if ($user_profile_id === '') {
            $user_profile = Auth::user()->user_profile;
        } else {
            $user_profile = UserProfile::find($user_profile_id);

            if (!$user_profile) {
                return redirect(url('/home'))->with('error', 'User Profile ID not found');
            }
        }

        $data = [
            'user_profile' => $user_profile,
            'user_roles' => UserRole::getRoleList(),
        ];

        return view('auth.profile')->with($data);
    }

    public function editUserProfile($user_profile_id, Request $request)
    {
        if (Auth::user()->user_profile->id !== intval($user_profile_id) && !Auth::user()->hasRole(UserRole::ROLE_ADMIN)) {
            throw new AuthorizationException('You can\'t edit other user\'s profile');
        }

        $user_profile = UserProfile::find($user_profile_id);

        if (!$user_profile) {
            return redirect(url('/home'))->with('error', 'User Profile ID not found');
        }

        $selected_roles = [];
        if (Auth::user()->hasRole(UserRole::ROLE_ADMIN)) {
            foreach (UserRole::getRoleList() as $code => $role) {
                if ($request->has($code . 'check') && $request->input($code . 'check') === 'checked') {
                    $selected_roles[] = $code;
                }
            }

            if (count($selected_roles) === 0) {
                return redirect(url('/users/' . $user_profile_id . '/view?action=edit'))->withInput(Input::all())->with('error', 'Please select at least one role for the user');
            }
        }

        $userProfileValidator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mobile_number' => ['required', 'min:11', 'max:15', 'string', 'regex:/^(\b09|\+?639)(\d{9})$/'],
            'tel_number' => ['nullable', 'string', 'regex:/^((\([0-9]{1,5}\)|[0-9]{0,5}){0,1}\s{0,1}([0-9]){3}-([0-9]){4}){0,1}$/'],
            'address' => 'required|string',
            'profile_image' => 'nullable|file|image|mimes:jpeg,jpg,png',
            'salutation' => 'string',
        ]);

        if ($userProfileValidator->fails()) {
            return redirect(url('/users/' . $user_profile_id . '/view?action=edit'))
                ->withInput()
                ->withErrors($userProfileValidator);
        }

        if ($request->hasFile('profile_image')) {
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fullFileNameToStore = $user_profile->user->id . '_' . time() . '.' . $extension;
            $tmbFileNameToStore = $user_profile->user->id . '_' . time() . '_tmb.' . $extension;
            $profile_image = $request->file('profile_image');
            $image_size_ratio = Image::make($profile_image->getRealPath())->width() / Image::make($profile_image->getRealPath())->height();

            Image::make($profile_image->getRealPath())->save(public_path('storage\\profile_images\\' . $fullFileNameToStore));
            Image::make($profile_image->getRealPath())->resize(200 * $image_size_ratio, 200)->save(public_path('storage\\profile_images\\' . $tmbFileNameToStore));

            $user_profile->profile_image = $fullFileNameToStore;
            $user_profile->profile_image_tmb = $tmbFileNameToStore;
        }

        if (Auth::user()->hasRole(UserRole::ROLE_ADMIN) && $user_profile->user->id !== 1) {
            $user = $user_profile->user;
            
            $user->roles = $selected_roles;
            if (!$user->save()) {
                return redirect()->back()->withInput(Input::all())->with('error', 'Error saving user roles');
            }
        }

        $user_profile->last_name = trim($request->last_name);
        $user_profile->middle_name = trim($request->middle_name);
        $user_profile->first_name = trim($request->first_name);
        $user_profile->salutation = $request->salutation;
        $user_profile->mobile_no = $request->mobile_number;
        $user_profile->tel_no = !$request->tel_number ? '' : $request->tel_number;
        $user_profile->address = $request->address;

        if ($user_profile->save()) {
            return redirect(Auth::user()->hasRole(UserRole::ROLE_ADMIN) ? url('/users') : url('/users/' . Auth::user()->user_profile->id . '/view'))->with('success', 'User profile updated successfully');
        } else {
            return redirect()->back()->with('error', 'Error updating user profile')->withInput(Input::all());
        }
    }

    public function updateUserPassword($user_id, Request $request)
    {
        if (Auth::user()->id !== intval($user_id)) {
            throw new AuthorizationException('You can only update your own password');
        }

        $user = User::find($user_id);

        $userPasswordValidator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed|min:8',
        ]);

        if ($userPasswordValidator->fails()) {
            return redirect('/users/' . $user->user_profile->id . '/view?action=change_password')->withErrors($userPasswordValidator);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect(url('/profile?action=change_password'))->with('error', 'Incorrect password');
        }

        $user->password = Hash::make($request->new_password);
        if ($user->save()) {
            Auth::logout();

            return redirect(url('/login'))->with('success', 'You have been logged out');
        } else {
            return redirect(url('/profile?action=change_password'))->with('error', 'Error updating password');
        }
    }
}
