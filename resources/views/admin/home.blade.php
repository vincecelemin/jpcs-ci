@extends('layouts.auth.app')

@section('content')
<div class="container-fluid">
    <strong>
        @if(Auth::user()->hasRole(\App\Role\UserRole::ROLE_ADMIN))
            Welcome {{Auth::user()->user_profile->getFullName(true)}}
        @endif
    </strong>
</div>
@endsection