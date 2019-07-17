@extends('layouts.app')

@section('content')
<div class="container">
        @if (session('Success'))
            <div class="alert alert-success">{{ session('Success') }}</div>
        @endif
    <div class="row justify-content-center">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Requested days</th>
                    <th>Requested at</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacations as $vacation)
                    <tr>
                        <td>{{ $vacation->user->name }}</td>
                        <td>{{ $vacation->user->email }}</td>
                        <td>{{ $vacation->from }}</td>
                        <td>{{ $vacation->to }}</td>
                        <td>{{ (strtotime($vacation->to) - strtotime($vacation->from)) /86400}}</td>
                        <td>{{ $vacation->created_at }}</td>
                        <td><a href="{{ route('myFinishedRequestDetails', $vacation->id) }}" class="btn btn-primary">More info</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $vacations->links() }}
</div>
@endsection