@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @auth
                        {{ __('You are logged in!') }}   
                        @if (count($reservations) == 0)
                            <p>No bookings found, click <a href="/bookings">here</a> to make a reservation.</p>
                        @else
                            <p>You have {{count($reservations)}} reservations.</p>
                        @endif
                    @endauth
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
