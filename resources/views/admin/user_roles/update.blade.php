@extends('layouts.auth.app')

@section('content')

    <div class="container-fluid">
        <strong>Update {{ $user_role->title }}</strong> <small>Role Id: {{ $user_role->id }}</small>
    
        <form action="{{ url('/users/roles/'.$user_role->id.'/update') }}" method="POST" class="container-fluid mt-2">
            @method('PUT')
            @csrf
            
            <div class="form-group">
                <label for="role_code">Role Code</label>
                <input type="text" class="form-control" name="role_code" id="role_code" placeholder="S_ROLE" value="{{ $user_role->code }}">
            </div>
    
            <div class="form-group">
                <label for="role_title">Title</label>
                <input type="text" class="form-control" name="role_title" id="role_title" aria-describedby="" placeholder="Role Title" value="{{ $user_role->title }}">
                <small id="" class="form-text text-muted"></small>
            </div>
    
            <div class="form-group">
                <label for="role_description">Description</label>
                <textarea class="form-control" name="role_description" id="role_description" rows="2">{{ $user_role->description }}</textarea>
            </div>
    
            <div class="text-right">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
    
@endsection