@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    <div class="row">
        @foreach ($stats as $label => $value)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title"><strong class="d-block">{{ $label }}</strong></div>
                        <div class="number dashtext-1">{{ $value }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h3 class="h5 mt-3">Latest bookings</h3>
    @include('admin.bookings._table', ['bookings' => $recentBookings, 'paginate' => false])
@endsection
