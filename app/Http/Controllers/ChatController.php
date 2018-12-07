<?php

namespace App\Http\Controllers;

use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function messages()
    {
        return Message::with('user')->limit(50)->get();
    }

    public function store(Request $request)
    {
        $message = $request->user()->messages()->create([
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($request->user(), $message))->toOthers();

        return ['message' => 'success'];
    }
}
