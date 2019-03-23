@extends('layouts.auth.app')

@section('content')
    <div class="container-fluid">
        <strong>Add a new Role</strong>
        <form action="{{ url('/users/roles/add') }}" class="container-fluid mt-2" method="POST">
            @csrf
            <div class="form-group">
              <label for="role_code">Role Code</label>
              <input type="text" class="form-control" name="role_code" id="role_code" placeholder="S_ROLE" value="{{ old('role_code') }}">
            </div>

            <div class="form-group">
              <label for="role_title">Title</label>
              <input type="text" class="form-control" name="role_title" id="role_title" aria-describedby="" placeholder="Role Title" value="{{ old('role_title') }}">
              <small id="" class="form-text text-muted"></small>
            </div>

            <div class="form-group">
              <label for="role_description">Description</label>
              <textarea class="form-control" name="role_description" id="role_description" rows="2">{{ old('role_description') }}</textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
@endsection