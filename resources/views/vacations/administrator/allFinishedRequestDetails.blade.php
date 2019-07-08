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
                    <th>Finished status</th>
                </tr>
            </thead>
            <tbody>
               <td>{{ $vacation->user->name }}</td>
               <td>{{ $vacation->from }}</td>
               <td>{{ $vacation->to }}</td>
               <td>{{ (strtotime($vacation->to) - strtotime($vacation->from)) /86400}}</td>
               <td>{{ $vacation->created_at }}</td>
               <td>
                   @if ($status === 3)
                        DENIED
                   @else
                       APPROVED
                   @endif
               </td>
            </tbody>
        </table>

        <h3 class="mt-5">Approvers</h3>
        <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approvers as $approver)
                        <tr>
                            <td>{{ $approver->user->name }}</td>
                            <td>{{ $approver->user->email }}</td>
                            <td>{{ $approver->status }}</td>
                            <td>{{ $approver->comment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
@endsection