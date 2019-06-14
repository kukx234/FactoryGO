@extends('layouts.app')

@section('content')
    <div class="container">

            <form class="form-inline mb-2" method="POST" action="{{ route('search') }}">
                @csrf
                <input class="form-control" type="email" name="email" placeholder="email" aria-label="Search" required>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>

            @if (session('Error'))
                <div class="alert alert-danger">{{ session('Error') }}</div>
            @endif

            @if (session('Success'))
                <div class="alert alert-success">{{ session('Success') }}</div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach ($allUsers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->attributes->first_name }}</td>
                        <td>{{ $user->attributes->last_name }}</td>
                        <td>{{ $user->attributes->email }}</td>
                        <td><a href="{{ route('saveNewUser', $user->id) }}" class="btn btn-primary">Add user</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection