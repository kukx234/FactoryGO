@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('Success'))
                <div class="alert alert-success">{{ session('Success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->role === 1)
        <table class="table table-striped mt-5">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ime</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>                    
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td><a href="{{ route('editUser',$user->id)}}" class="btn btn-secondary">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    @endif
</div>
@endsection
