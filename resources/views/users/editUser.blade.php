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
                                <label for="start_date">Start date</label>
                                <input type="text" name="start_date" id="start_date" value="{{ $user->created_at }}" class="form-control"> 
                            </div>

                            <label for="approvers">Approver</label>
                            <select name="approvers" id="approvers" class="custom-select mb-4" required>
                                @foreach ($approvers as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary mr-4" name="submit" value="save">Save and Activate</button>
                            <button type="submit" class="btn btn-danger" name="submit" value="suspend">Suspend</button>
                            <a href="{{ route('allUsers') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection