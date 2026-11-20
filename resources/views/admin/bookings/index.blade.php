@extends('layouts.admin')

@section('title', 'Bookings')
@section('heading', 'Bookings')

@section('content')
    @include('admin.bookings._table', ['paginate' => true])
@endsection
