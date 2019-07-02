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

                            <label for="">Approver</label>
                            <select class="custom-select mb-4">
                                <option selected>Open this select menu</option>
                                @foreach ($approvers as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary mr-4">Save and Activate</button>
                            <button type="submit" class="btn btn-danger">Suspend</button>
                            <button type="submit" class="btn btn-secondary">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection