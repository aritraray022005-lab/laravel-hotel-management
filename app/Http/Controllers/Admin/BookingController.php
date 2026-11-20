<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('admin.bookings.index', [
            'bookings' => Booking::with('room')->latest()->paginate(15),
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(Booking::STATUSES)],
        ]);

        // Confirming must not create a double booking.
        if ($data['status'] !== Booking::CANCELLED
            && $booking->status === Booking::CANCELLED
            && ! $booking->room->isAvailable($booking->start_date->toDateString(), $booking->end_date->toDateString())) {
            return back()->withErrors(['status' => 'Those dates are no longer free for this room.']);
        }

        $booking->update($data);

        return back()->with('success', 'Booking updated.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('success', 'Booking deleted.');
    }
}
