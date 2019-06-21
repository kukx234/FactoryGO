@extends('layouts.app')

@section('content')
<div class="container">
    
        @if (session('Error'))
            <div class="alert alert-danger" role="alert">
                {{ session('Error') }}
            </div>
        @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New vacation request</div>

                <div class="card-body">
                    <form action="" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="fromDate">From</label>
                            <input type="date" name="from" id="from" class="form-control" required> 
                        </div>

                        <div class="form-group">
                            <label for="toDate">To</label>
                            <input type="date" name="to" id="toDate"  class="form-control" required> 
                        </div>

                        <button type="submit" class="btn btn-primary">Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection