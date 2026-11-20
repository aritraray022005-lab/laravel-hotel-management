<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Room;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'Rooms' => Room::count(),
                'Bookings' => Booking::count(),
                'Pending bookings' => Booking::where('status', Booking::PENDING)->count(),
                'Messages' => ContactMessage::count(),
            ],
            'recentBookings' => Booking::with('room')->latest()->take(5)->get(),
        ]);
    }
}
