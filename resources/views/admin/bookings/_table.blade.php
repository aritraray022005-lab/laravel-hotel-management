<div class="table-responsive">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Guest</th>
                <th>Room</th>
                <th>Stay</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>
                        {{ $booking->name }}<br>
                        <small>{{ $booking->email }} &middot; {{ $booking->phone }}</small>
                    </td>
                    <td>{{ $booking->room?->title }}</td>
                    <td>
                        {{ $booking->start_date->format('d M Y') }} &rarr; {{ $booking->end_date->format('d M Y') }}
                        <br><small>{{ $booking->nights }} night(s)</small>
                    </td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td class="text-nowrap">
                        @foreach (['confirmed' => 'btn-success', 'cancelled' => 'btn-warning'] as $status => $class)
                            @if ($booking->status !== $status)
                                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button type="submit" class="btn btn-sm {{ $class }}">{{ $status === 'confirmed' ? 'Confirm' : 'Cancel' }}</button>
                                </form>
                            @endif
                        @endforeach
                        <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="d-inline" onsubmit="return confirm('Delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No bookings yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if (($paginate ?? true) && method_exists($bookings, 'links'))
    <div class="mt-3">{{ $bookings->links() }}</div>
@endif
