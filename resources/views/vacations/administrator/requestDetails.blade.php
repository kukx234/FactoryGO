@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3>Employe vacation Request</h3>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Requested days</th>
                    <th>Requested at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacations as $vacation)
                    <tr>
                        <td>{{ $vacation->users->name }}</td>
                        <td>{{ $vacation->from }}</td>
                        <td>{{ $vacation->to }}</td>
                        <td>{{ (strtotime($vacation->to) - strtotime($vacation->from)) /86400}}</td>
                        <td>{{ $vacation->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form action="" method="POST">
        @csrf
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
        </div>
    </form>
    <a href="" class="btn btn-primary btn-lg mt-4 mr-4">Approve</a>
    <a href="" class="btn btn-secondary btn-lg mt-4">Reject</a>
</div>
@endsection