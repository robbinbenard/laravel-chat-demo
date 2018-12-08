<?php

namespace App\Http\Controllers;

use App\Room;
use App\Events\RoomCreated;
use App\Events\RoomDeleted;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a room
     *
     * @param  Room $room
     * @return void
     */
    public function index(Room $room)
    {
        return view('rooms', compact('room'));
    }

    /**
     * Get all the rooms
     *
     * @return void
     */
    public function all()
    {
        return Room::all();
    }

    /**
     * Show a room
     *
     * @param  Room $room
     * @return void
     */
    public function show(Room $room)
    {
        return view('room', compact('room'));
    }

    /**
     * Store a new room
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $room = Room::create(['name' => $request->name]);

        broadcast(new RoomCreated($room))->toOthers();

        return $room;
    }

    /**
     * Delete a room
     *
     * @param Room $room
     * @return void
     */
    public function destroy(Room $room)
    {
        broadcast(new RoomDeleted($room))->toOthers();

        $room->delete();
    }
}
