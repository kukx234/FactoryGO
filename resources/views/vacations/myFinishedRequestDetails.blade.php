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
                    <th>Number of Approvers</th>
                    <th>Requested at</th>
                    <th>Finished status</th>
                </tr>
            </thead>
            <tbody>
               <td>{{ $data['vacation']->user->name }}</td>
               <td>{{ $data['vacation']->from }}</td>
               <td>{{ $data['vacation']->to }}</td>
               <td>{{ (strtotime($data['vacation']->to) - strtotime($data['vacation']->from)) /86400}}</td>
               <td>{{ $data['countApprovers'] }}</td>
               <td>{{ $data['vacation']->created_at }}</td>
               <td>{{ $data['vacation']->status }}</td>
            </tbody>
        </table>

        <h3 class="mt-5">Approvers</h3>
        <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Resolved at</th>
                        <th>Status</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['approvers'] as $approver)
                        <tr>
                            <td>{{ $approver->user->name }}</td>
                            <td>{{ $approver->user->email }}</td>
                            <td>{{ $approver->updated_at }}</td>
                            <td>{{ $approver->status }}</td>
                            <td>{{ $approver->comment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    @if (Role::check() === Roles::ADMIN && $data['vacation']->status === VacationStatus::DENIED)
        <form action="{{ route('approveRequest', $data['vacation']->id) }}" method="POST">
            @csrf
            <div class="form-group mt-5">
                <label for="comment">Comment</label>
                <textarea name="comment" id="comment"  cols="30" rows="10" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" value="Approved" name="submit">Approve</button>
        </form>
    @endif
</div>
@endsection