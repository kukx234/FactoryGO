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
                    @if($user->status === UserStatus::PENDING)
                    You are logged in! Waiting for Admin's approval.

                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Old Vacation</th>
                                <th>New Vacation</th>
                                <th>Requests waiting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ floor($user->old_vacation) }} day</td>
                                <td>{{ floor($user->new_vacation) }} day</td>
                                <td>{{ $requestWaitingCount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <table class="table mt-5">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Number of approvers</th>
                    <th>Requested days</th>
                    <th>Requested at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestsWaiting as $requestWaiting)
                    <tr>
                        <td>{{ $requestWaiting->user->name }}</td>
                        <td>{{ $requestWaiting->user->email }}</td>
                        <td>{{ $requestWaiting->from }}</td>
                        <td>{{ $requestWaiting->to }}</td>
                        <td>{{ CountApprovers::countApprovers($requestWaiting->user->id) }}</td>
                        <td>{{ (strtotime($requestWaiting->to) - strtotime($requestWaiting->from)) /86400}}</td>
                        <td>{{ $requestWaiting->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
