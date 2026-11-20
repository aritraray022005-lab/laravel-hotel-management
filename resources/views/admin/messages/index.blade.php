@extends('layouts.admin')

@section('title', 'Messages')
@section('heading', 'Messages')

@section('content')
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Message</th>
                    <th>Received</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr>
                        <td>
                            {{ $message->name }}<br>
                            <small><a href="mailto:{{ $message->email }}">{{ $message->email }}</a>@if ($message->phone) &middot; {{ $message->phone }}@endif</small>
                        </td>
                        <td style="white-space: pre-line;">{{ $message->message }}</td>
                        <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $messages->links() }}</div>
@endsection
