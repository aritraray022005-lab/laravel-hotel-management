<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $dates = $request->validate([
            'arrival' => ['nullable', 'required_with:departure', 'date', 'after_or_equal:today'],
            'departure' => ['nullable', 'required_with:arrival', 'date', 'after:arrival'],
        ]);

        $arrival = $dates['arrival'] ?? null;
        $departure = $dates['departure'] ?? null;

        $rooms = Room::query()
            ->when($arrival && $departure, fn ($query) => $query->available($arrival, $departure))
            ->latest()
            ->get();

        return view('site.home', compact('rooms', 'arrival', 'departure'));
    }
}
