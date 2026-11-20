<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * "My bookings" for the logged-in guest.
     */
    public function index(Request $request): View
    {
        $bookings = $request->user()
            ->bookings()
            ->with('room')
            ->latest()
            ->paginate(10);

        return view('site.bookings.index', compact('bookings'));
    }

    public function store(StoreBookingRequest $request, Room $room): RedirectResponse
    {
        $data = $request->validated();

        $booking = DB::transaction(function () use ($room, $data, $request) {
            if (! $room->isAvailable($data['start_date'], $data['end_date'])) {
                return null;
            }

            return $room->bookings()->create($data + [
                'user_id' => $request->user()?->id,
                'status' => Booking::PENDING,
            ]);
        });

        if (! $booking) {
            return back()
                ->withInput()
                ->withErrors(['start_date' => 'Sorry, this room is already booked for those dates. Please pick different dates.']);
        }

        return redirect()
            ->route('rooms.show', $room)
            ->with('success', 'Thank you! Your booking request has been received and is awaiting confirmation.');
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === $request->user()->id, 403);

        if ($booking->isCancellable()) {
            $booking->update(['status' => Booking::CANCELLED]);
        }

        return back()->with('success', 'Your booking has been cancelled.');
    }
}
