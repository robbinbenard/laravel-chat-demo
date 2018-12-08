<?php

namespace App\Http\Controllers;

use App\Room;
use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get all of the rooms messages
     *
     * @param  Room $room
     * @return void
     */
    public function messages(Room $room)
    {
        return $room->messages()->with('user')->limit(50)->get();
    }

    /**
     * Store a new message
     *
     * @param  Request $request
     * @param  Room $room
     * @return void
     */
    public function store(Request $request, Room $room)
    {
        $message = $room->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        $message->user = $request->user();

        broadcast(new MessageSent($room, $message))->toOthers();

        return $message;
    }
}
