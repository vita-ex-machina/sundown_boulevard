@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($reservations) == 0)
            <p>No bookings found</p>
        @else
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Reserved by</th>
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
                            @auth
                                @if (auth()->user()->id==$reservation->user->id)
                                    {{ $reservation->user->name }}    
                                @else
                                    **********   
                                @endif    
                            @endauth
                            @guest
                                    **********   
                            @endguest    
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
            {{-- pagination --}}
            <div class="d-flex justify-content-center">
                {!! $reservations->links() !!}
            </div>

        @endif

        {{-- @if($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
        @endif --}}

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}  
            </div><br />
        @endif

        @if(session()->get('failure'))
            <div class="alert alert-danger">
                {{ session()->get('failure') }}  
            </div><br />
        @endif
        @auth
        <h2>Make a booking</h2>
        <h4>The restaurant is open from 16:00 – 22:00 every day</h4>
        
        <form action="{{ route('bookings') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="reservation_date">Date:</label>
                    <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" name="reservation_date" id="reservation_date" placeholder="dd.MM.YY" value="{{ old('reservation_date') }}"> 
                    @error('reservation_date')
                    <small class="text-danger">
                        {{ $message }}
                    </small>  
                    @enderror   
                </div>
                <div class="form-group col-md-4">
                    <label for="start_time">Start time:</label>
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" name ="start_time" id="start_time" placeholder="__:__" value="{{ old('start_time') }}">
                    @error('start_time')
                    <small class="text-danger">
                        The resturent is open from 16:00
                    </small>  
                    @enderror   
                </div>
                {{-- <div class="form-group col-md-4">
                    <label for="end_time">End time:</label>
                    <input type="time" class="form-control @error('end_time')
                    is-invalid @enderror" name="end_time" id="end_time" placeholder="__:__">
                    @error('end_time')
                    <small class="text-danger">
                        {{ $message }}
                    </small>  
                    @enderror   
                </div> --}}
                <div class="form-group col-md-4">
                    <label for="end_time">Duration hours:</label>
                    <select name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror">
                        <option value="2">2</option>
                        <option value="4">4</option>
                        <option value="6">6</option>
                    </select>
                    @error('end_time')
                    <small class="text-danger">
                        The resturent closes at 22:00
                    </small>  
                    @enderror   
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="number_people">Number of people:</label>
                    <select name="number_people" id="number_people" class="form-control">
                        @for ($i = 2; $i <= 10; $i++)
                            <option value="{{$i}}">{{ $i }}</option>
                        @endfor
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="drink_name">Select drink:</label>
                    <select name="drink_name" id="drink_name" class="form-control">
                        @foreach ($drink_json as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="dish_name">Select dish:</label>
                    <select name="dish_name" id="dish_name" class="form-control">
                        <option value="{{ $meal_json->meals[0]->strMeal }}">{{ $meal_json->meals[0]->strMeal }}</option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id}}">
            <br/>
            <button type="submit" class="btn btn-block btn-primary">Create Booking</button>
        </form>
        @endauth      
    </div>
@endsection
