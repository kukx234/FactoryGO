@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit user</div>
    
                    <div class="card-body">
                        <form action="{{ route('updateUser', $user->id)}}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control"> 
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control"> 
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="number" name="role" id="role" value="{{ $user->role }}" class="form-control"> 
                            </div>

                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection