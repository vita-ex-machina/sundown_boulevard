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
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Start time</th>
                                    <th scope="col">End time</th>
                                    <th scope="col" class="text-center">Tabels reserved</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $reservation) 
                                    <tr>
                                        <th scope="row">{{ $reservation->id }}</th>
                                        <td>
                                            <form action="{{ route('destroy', $reservation->id)}}" method="post" style="display: inline-block">
                                                @csrf
                                                
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        </td>
                                        <td>{{ $reservation->reservation_date }}</td>
                                        <td>{{ $reservation->start_time }}</td>
                                        <td>{{ $reservation->end_time }}</td>
                                        <td class="text-center">
                                            @foreach ($reservation->tables as $table)
                                            {{ $table->name }} <br/>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    @endauth
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
