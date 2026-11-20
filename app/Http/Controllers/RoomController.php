<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Contracts\View\View;

class RoomController extends Controller
{
    public function show(Room $room): View
    {
        return view('site.rooms.show', compact('room'));
    }
}
