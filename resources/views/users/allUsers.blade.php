@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('Success'))
        <div class="alert alert-success">{{ session('Success') }}</div>
    @endif

    <div class="row justify-content-center">
        <h3>All users list</h3>
    </div>
    <table class="table table-striped mt-3">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Start date</th>
                <th scope="col">Vacation</th>
                <th scope="col">Old Vacation</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
             @foreach ($users as $user)
                <tr>                   
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ floor($user->new_vacation) }} day</td>
                    <td>{{ floor($user->old_vacation) }} day</td>
                    <td>
                        @if (Role::check() === Roles::ADMIN)
                            <a href="{{ route('editUser',$user->id)}}" class="btn btn-secondary">Edit</a>
                        @endif
                        <a href="{{ route('userInfo',$user->id)}}" class="btn btn-primary">More info</a>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
