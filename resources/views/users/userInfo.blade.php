@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">EMAIL : {{ $user->email }}</li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                    OLD VACATION
                            <span class="badge badge-primary badge-pill">{{ floor($user->old_vacation) }}</span>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                    NEW VACATION
                            <span class="badge badge-primary badge-pill">{{ floor($user->new_vacation) }}</span>
                            <li class="list-group-item">START DATE : {{ date_format($user->created_at, 'd-m-Y') }}</li>
                            <li class="list-group-item">APPROVERS
                                <ul class="list-group">
                                    @if (empty($approvers))
                                        <li class="list-group-item">Doesn't have assigned approver</li>
                                    @endif
                                    @foreach ($approvers as $approver)
                                        <li class="list-group-item">{{ $approver->name }}</li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="list-group-item">STATUS : {{ $user->status }}</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
