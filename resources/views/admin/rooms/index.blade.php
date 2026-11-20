@extends('layouts.admin')

@section('title', 'Rooms')
@section('heading', 'Rooms')

@section('content')
    <p><a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add room</a></p>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Wi-Fi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rooms as $room)
                    <tr>
                        <td><img src="{{ $room->image_url }}" alt="" width="90"></td>
                        <td>{{ $room->title }}<br><small>{{ \Illuminate\Support\Str::limit($room->description, 80) }}</small></td>
                        <td>{{ $room->type_label }}</td>
                        <td>{{ config('hotel.currency') }}{{ number_format($room->price, 2) }}</td>
                        <td>{{ $room->has_wifi ? 'Yes' : 'No' }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="d-inline" onsubmit="return confirm('Delete this room?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No rooms yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $rooms->links() }}</div>
@endsection
