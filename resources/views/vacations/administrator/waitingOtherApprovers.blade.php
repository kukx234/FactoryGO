@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('Success'))
        <div class="alert alert-success">{{ session('Success') }}</div> 
    @endif
    <div class="row justify-content-center">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Number of approvers</th>
                    <th>Requested days</th>
                    <th>Old Vacation</th>
                    <th>Vacation</th>
                    <th>Requested at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacations as $vacation)
                    <tr>
                        <td>{{ $vacation->user->name }}</td>
                        <td>{{ $vacation->user->email }}</td>
                        <td>{{ $vacation->from }}</td>
                        <td>{{ $vacation->to }}</td>
                        <td>{{ CountApprovers::countApprovers($vacation->user->id) }}</td>
                        <td>{{ (strtotime($vacation->to) - strtotime($vacation->from)) /86400}}</td>
                        <td>{{ $vacation->user->old_vacation }}</td>
                        <td>{{ $vacation->user->new_vacation }}</td>
                        <td>{{ $vacation->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $vacations->links() }}
</div>
@endsection