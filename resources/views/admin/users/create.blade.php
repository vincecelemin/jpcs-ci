@extends('layouts.auth.app') 
@section('user_nav_link') active
@endsection
 
@section('content')
<div class="container-fluid main-block">
  <strong>Create a new User</strong> 
  @if ($errors->any()) 
  {{$errors}} 
  @endif

  <form action="{{ url('/users/add') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <strong>User Account Details</strong>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" aria-describedby="emailHelpId"
              placeholder="user@pondongbatangan.org" value="{{ old('email') }}">
            <small id="emailHelpId" class="form-text text-muted">To be used as username, must be unique</small>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password"
              placeholder="">
          </div>

          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation"
              id="password_confirmation" placeholder="">
          </div>

          <div>
            <label>User Role/s</label>
            <div class="row">
              @foreach ($user_roles as $code => $role)
              <div class="col-3 d-flex">
                <label class="switch switch-success mr-2">
                  <input value="checked" type="checkbox" class="switch-input{{ $code === \App\Role\UserRole::ROLE_ADMIN ? ' admin-switch' : ''}}" id="{{$code.'check'}}" name="{{$code.'check'}}"
                  @if($code === \App\Role\UserRole::ROLE_ADMIN)
                    onchange='$(".switch-input:not(.admin-switch)").attr("disabled", $(this).prop("checked"));'
                  @endif
                  >
                  <span class="switch-slider"></span>
                </label>
                <label for="{{$code.'check'}}">{{$role}}</label>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <strong>User Profile Details</strong>
        <div class="row">
          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" id="first_name"
                aria-describedby="" placeholder="" value="{{ old('first_name') }}">
              <small id="" class="form-text text-muted"></small>
            </div>
          </div>
          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label for="middle_name">Middle Name</label>
              <input type="text" name="middle_name" id="middle_name" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}"
                placeholder="" aria-describedby="" value="{{ old('middle_name') }}">
              <small id="" class="text-muted"></small>
            </div>
          </div>
          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" id="last_name"
                aria-describedby="" placeholder="" value="{{ old('last_name') }}">
              <small id="" class="form-text text-muted"></small>
            </div>
          </div>

          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label for="salutation">Salutation</label>
              <input type="text" class="form-control{{ $errors->has('salutation') ? ' is-invalid' : '' }}" name="salutation" id="salutation"
                aria-describedby="" placeholder="" value="{{ old('salutation') }}">
              <small id="" class="form-text text-muted"></small>
            </div>
          </div>

          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label for="mobile_number">Mobile Number</label>
              <input type="text" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" name="mobile_number" id="mobile_number"
                aria-describedby="" placeholder="+63" value="{{ old('mobile_number') }}">
              <small id="" class="form-text text-muted"></small>
            </div>
          </div>

          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label for="tel_number">Telephone Number</label>
              <input type="text" class="form-control{{ $errors->has('tel_number') ? ' is-invalid' : '' }}" name="tel_number" id="tel_number"
                aria-describedby="" placeholder="(043) 757-3714" value="{{ old('tel_number') }}">
              <small id="" class="form-text text-muted"></small>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="address" aria-describedby=""
                placeholder="Batangas" value="{{ old('address') }}">
              <small id="" class="form-text text-muted"></small>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label for="profile_image">Profile Image</label>
              <input type="file" class="form-control-file{{ $errors->has('profile_image') ? ' is-invalid' : '' }}" name="profile_image"
                id="profile_image" placeholder="Select File" aria-describedby="fileHelpId" accept=".jpg,.jpeg,.png">
              <small id="fileHelpId" class="form-text text-muted">Supports .jpg/.jpeg/.png files only</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="text-right">
      <button class="btn btn-success">Add User</button>
    </div>
  </form>
</div>
@endsection