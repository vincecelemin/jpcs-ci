@extends('layouts.auth.app') 
@section('user_nav_link') active
@endsection
 
@section('content')
<div class="container-fluid main-block">
    <div class="container-fluid p-0">
        <strong>Registered Users</strong>
        <div class="my-1 d-flex">
            <div class="mr-auto d-inline-block">
                <a class="btn btn-success btn-sm my-1" href={{url( '/users/add')}}>Add new</a>
                <button class="btn btn-outline-info btn-sm my-1" onclick="$('.disabled-account').fadeToggle(100)">Hide disabled accounts </button>    
            </div>
        </div>
        <div id="usersAccordion" role="tablist" aria-multiselectable="true">
            @foreach ($registered_users as $user_role => $users)
            <div class="card mb-2">
                <div class="card-header" role="tab" id="{{$user_role}}Header">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#usersAccordion" href="#{{$user_role}}Content" aria-expanded="true" aria-controls="{{$user_role}}Content">
                                    {{\App\Role\UserRole::getRoleList()[$user_role]}}
                                    </a>
                    </h5>
                </div>
                <div id="{{$user_role}}Content" class="collapse in{{ $user_role === array_keys($registered_users)[0] ? ' show' : ''}}" role="tabpanel"
                    aria-labelledby="{{$user_role}}Header">
                    <div class="card-body">
                        <p>
                            <strong class="d-block">
                                {{ $user_roles[$user_role]['description'] }}
                            </strong>
                            <small><i>Role Code: {{ $user_role }}</i></small>
                        </p>
                        <ul class="list-group">
                            @foreach ($users as $user)
                            <li class="list-group-item account-list-item {{ !$user->is_active ? " disabled-account " : " " }}">
                                <div class="row">
                                    <div class="col-sm-2 col-md-1 col-3">
                                        <img src="/storage/profile_images/{{ $user->user_profile->profile_image_tmb }}" alt="{{ $user->user_profile->first_name }}"
                                            width="100%">
                                    </div>
                                    <div class="col-sm-6 col-md-7 col-4">
                                        <p class="mb-0">
                                            <strong>{{ $user->user_profile->getFullName() }}</strong>
                                        </p>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-5 text-right">
                                        <a href="{{ url('/users/'.$user->user_profile->id.'/view') }}" class="btn btn-link">View Profile</a>
                                        <a href="{{ url('/users/'.$user->user_profile->id.'/view?action=edit') }}" class="btn btn-link">Update</a>                                        @if (Auth::user()->id !== $user->id) @if($user->is_active)
                                        <a href="{{ url('/users/'.$user->id.'/disable') }}" class="btn btn-link text-danger">Disable</a>                                        @elseif(!$user->is_active)
                                        <a href="{{ url('/users/'.$user->id.'/enable') }}" class="btn btn-link text-success">Enable</a>                                        @endif @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection