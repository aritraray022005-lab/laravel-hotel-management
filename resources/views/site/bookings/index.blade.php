@extends('layouts.site')

@section('title', 'My bookings | '.config('hotel.name'))

@section('content')
    <div class="our_room">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage"><h2>My bookings</h2></div>
                </div>
            </div>

            @include('partials.flash')

            @if ($bookings->isEmpty())
                <p class="text-center">You have no bookings yet. <a href="{{ route('site.home') }}#rooms">Browse our rooms</a>.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered bg-white">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Arrival</th>
                                <th>Departure</th>
                                <th>Nights</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->room->title }}</td>
                                    <td>{{ $booking->start_date->format('d M Y') }}</td>
                                    <td>{{ $booking->end_date->format('d M Y') }}</td>
                                    <td>{{ $booking->nights }}</td>
                                    <td>{{ ucfirst($booking->status) }}</td>
                                    <td>
                                        @if ($booking->isCancellable())
                                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}" onsubmit="return confirm('Cancel this booking?');">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-danger" type="submit">Cancel</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $bookings->links() }}
            @endif
        </div>
    </div>
@endsection
