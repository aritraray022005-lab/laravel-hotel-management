@extends('layouts.site')

@section('title', $room->title.' | '.config('hotel.name'))

@section('content')
    <div class="our_room">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>{{ $room->title }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="room">
                        <div class="room_img" style="padding: 20px;">
                            <img src="{{ $room->image_url }}" alt="{{ $room->title }}" style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="bed_room">
                            <p>{{ $room->description }}</p>
                            <h4 style="padding: 12px">Free Wi-Fi: {{ $room->has_wifi ? 'Yes' : 'No' }}</h4>
                            <h4 style="padding: 12px">Room type: {{ $room->type_label }}</h4>
                            <h3 style="padding: 12px">Price: {{ config('hotel.currency') }}{{ number_format($room->price, 2) }} / night</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h2>Book this room</h2>

                    @include('partials.flash')

                    <form action="{{ route('bookings.store', $room) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', auth()->user()?->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', auth()->user()?->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()?->phone) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Arrival</label>
                            <input id="start_date" type="date" name="start_date" class="form-control" min="{{ now()->toDateString() }}" value="{{ old('start_date', request('start_date')) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Departure</label>
                            <input id="end_date" type="date" name="end_date" class="form-control" min="{{ now()->addDay()->toDateString() }}" value="{{ old('end_date', request('end_date')) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Book Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
