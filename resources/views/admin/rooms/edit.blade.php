@extends('layouts.admin')

@section('title', 'Edit room')
@section('heading', 'Edit room')

@section('content')
    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.rooms._form')
    </form>
@endsection
