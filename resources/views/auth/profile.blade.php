@extends('layouts.auth.app') 
@section('user_nav_link') active
@endsection
 
@section('profile_nav_link') 
@if(Auth::user()->user_profile->id === intval($user_profile->id))
active
@endif
@endsection

@section('content')
<div class="container-fluid main-block">

  <div class="container float-left bg-white rounded py-3">
    <div class="row p-2" id="profile_view">
      <div class="text-right col-12">
        @if(Auth::user()->user_profile->id === intval($user_profile->id))
          <button class="btn btn-outline-info btn-sm" id="edit_password_btn">
            <i class="fa fa-key"></i> Update Password
          </button>
        @endif
        <button class="btn btn-outline-info btn-sm" id="edit_profile_btn">
          <i class="fa fa-edit"></i> Edit Profile
        </button>
      </div>
      <div class="col-6 col-sm-2">
        <img class="border border-light shadow-sm" src="{{ '/storage/profile_images/'.$user_profile->profile_image }}" alt="{{ $user_profile->first_name }}"
          width="100%">
      </div>
      <div class="col-6 col-sm-10">
        <small class="d-block">Full Name</small>
        <p class="font-weight-bold">{{ $user_profile->getFullName(true) }}</p>
        <small class="d-block">Contact Information</small>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-5">
            <span class="d-block">
              Email Address
            </span>
            <p class="font-weight-bold">{{ $user_profile->user->email }}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <span class="d-block">
              Mobile Number
            </span>
            <p class="font-weight-bold">{{ $user_profile->mobile_no }}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <span class="d-block">
              Telephone Number
            </span>
            <p class="font-weight-bold">{{ $user_profile->tel_no }}</p>
          </div>
  
          <div class="col-12">
            <span class="d-block">
              Address
            </span>
            <p class="font-weight-bold">{{ $user_profile->address }}</p>
          </div>
        </div>
  
        <span class="d-block">
          User Roles
        </span>
        <p class="font-weight-bold">
          @foreach ($user_profile->user->getRoleNames() as $index => $role) 
            {{ $role.($index !== count($user_profile->user->getRoleNames())-1 ? ', ' : '') }} 
          @endforeach
        </p>
      </div>
    </div>
    <div id="edit_profile" class="hide">
      <form action="{{ url('/users/'.$user_profile->id.'/edit') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
            {{ $errors }}
        @endif
        <div class="row p-2">
          <div class="col-12 col-sm-2">
            <img class="border border-light shadow-sm" src="{{ '/storage/profile_images/'.$user_profile->profile_image }}" alt="{{ $user_profile->first_name }}"
              width="100%">
    
            <div class="form-group mt-2">
              <label for="profile_image">New Profile Image</label>
              <input type="file" class="form-control-file{{ $errors->has('profile_image') ? ' is-invalid' : '' }}" name="profile_image"
                id="profile_image" placeholder="Select File" aria-describedby="fileHelpId" accept=".jpg,.jpeg,.png">
              <small id="fileHelpId" class="form-text text-muted">Supports .jpg/.jpeg/.png files only</small>
            </div>
          </div>
          <div class="row col-12 col-sm-10">
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" id="first_name"
                  aria-describedby="" placeholder="" value="{{ $errors->has('first_name') ? old('first_name') : $user_profile->first_name }}">
                <small id="" class="form-text text-muted"></small>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}"
                  placeholder="" aria-describedby="" value="{{ $errors->has('middle_name') ? old('middle_name') : $user_profile->middle_name }}">
                <small id="" class="text-muted"></small>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" id="last_name"
                  aria-describedby="" placeholder="" value="{{ $errors->has('last_name') ? old('last_name') : $user_profile->last_name }}">
                <small id="" class="form-text text-muted"></small>
              </div>
            </div>
    
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="salutation">Salutation</label>
                <input type="text" class="form-control{{ $errors->has('salutation') ? ' is-invalid' : '' }}" name="salutation" id="salutation"
                  aria-describedby="" placeholder="" value="{{ $errors->has('salutation') ? old('salutation') : $user_profile->salutation }}">
                <small id="" class="form-text text-muted"></small>
              </div>
            </div>
    
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" name="mobile_number" id="mobile_number"
                  aria-describedby="" placeholder="+63" value="{{ $errors->has('mobile_number') ? old('mobile_number') : $user_profile->mobile_no }}">
                <small id="" class="form-text text-muted"></small>
              </div>
            </div>
    
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="tel_number">Telephone Number</label>
                <input type="text" class="form-control{{ $errors->has('tel_number') ? ' is-invalid' : '' }}" name="tel_number" id="tel_number"
                  aria-describedby="" placeholder="(043) 757-3714" value="{{ $errors->has('tel_number') ? old('tel_number') : $user_profile->tel_no }}">
                <small id="" class="form-text text-muted"></small>
              </div>
            </div>
    
            <div class="col-12">
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="address" aria-describedby=""
                  placeholder="Batangas" value="{{ $errors->has('address') ? old('address') : $user_profile->address }}">
                <small id="" class="form-text text-muted"></small>
              </div>
            </div>
  
            @if (Auth::user()->hasRole(\App\Role\UserRole::ROLE_ADMIN) && $user_profile->user->id !== 1)
            <div class="col-12">
              <label>User Role/s</label>
              <div class="row">
                @foreach ($user_roles as $code => $role)
                <div class="col-12 col-sm-6 col-md-4 d-flex">
                  <label class="switch switch-success mr-2">
                    <input value="checked" type="checkbox" class="switch-input{{ $code === \App\Role\UserRole::ROLE_ADMIN ? ' admin-switch' : ''}}" id="{{$code.'check'}}" name="{{$code.'check'}}" 
                    @if($code === \App\Role\UserRole::ROLE_ADMIN)
                      onchange='$(".switch-input:not(.admin-switch)").attr("disabled", $(this).prop("checked"));'
                    @endif>
                    <span class="switch-slider"></span>
                  </label>
                  <label for="{{$code.'check'}}">{{$role}}</label>
                </div>
                @endforeach
              </div>
            </div>
            @endif
    
            <div class="col-12 text-right mt-2">
              <button type="button" class="btn btn-danger" id="cancel_edit_btn">Cancel</button>
              <button type="submit" class="btn btn-success">Update Profile</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  
    @if (Auth::user()->user_profile->id === intval($user_profile->id))
    <div class="hide" id="edit_password">
      <form action="{{ url('/users/'.Auth::user()->id.'/update_password') }}" method="post">
        @csrf
        @method('PUT')
  
        <div class="mb-2">
          <strong>Update your password</strong>
          <small class="d-block"><i>Please use a password that you would remember</i></small>
        </div>
  
        <div class="form-group">
          <label for="old_password">Old Password</label>
          <input type="password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" id="old_password" aria-describedby="" placeholder="">
          <small id="" class="form-text text-muted"></small>
        </div>
  
        <div class="form-group">
          <label for="new_password">New Password</label>
          <input type="password" class="form-control" name="new_password{{ $errors->has('new_password') ? ' is-invalid' : '' }}" id="new_password" placeholder="">
        </div>
  
        <div class="form-group">
          <label for="new_password_confirmation">Confirm Password</label>
          <input type="password" class="form-control" name="new_password_confirmation{{ $errors->has('new_password') ? ' is-invalid' : '' }}" id="new_password_confirmation" placeholder="">
        </div>
  
        <div class="text-right">
          <button type="button" class="btn btn-danger" id="cancel_edit_password_btn">Cancel</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
    @endif
  </div>
</div>
@endsection

@if(Auth::user()->hasRole(\App\Role\UserRole::ROLE_ADMIN) || Auth::user()->user_profile->id === $user_profile->id)
@section('scripts')
<script>
  $(document).ready(() => {
      $("#edit_profile_btn").on('click', () => {
        $("#profile_view").hide();
        $("#edit_profile").fadeIn();
      });
      $("#edit_password_btn").on('click', () => {
        $("#profile_view").hide();
        $("#edit_password").fadeIn();
      });
      $("#cancel_edit_btn").on('click', () => {
        $("#edit_profile").hide();
        $("#profile_view").fadeIn();
      });
      $("#cancel_edit_password_btn").on('click', () => {
        $("#edit_password").hide();
        $("#profile_view").fadeIn();
      });
    });
</script>

@if(app('request')->input('action') === 'edit')
<script>
  $(document).ready(() => {
    $("#edit_profile_btn").trigger('click');
  });
</script>
@elseif(app('request')->input('action') === 'change_password')
<script>
  $(document).ready(() => {
    $("#edit_password_btn").trigger('click');
  });
</script>
@endif
@if(Auth::user()->hasRole(\App\Role\UserRole::ROLE_ADMIN))
<script>
  $(document).ready(function() {
    @foreach($user_profile->user->getRoles() as $role)
    $("label[for={{$role}}check]").trigger('click');
    @endforeach
  });
</script>
@endif
@endsection
@endif