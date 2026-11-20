@extends('layouts.admin')

@section('title', 'Add room')
@section('heading', 'Add room')

@section('content')
    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.rooms._form')
    </form>
@endsection
