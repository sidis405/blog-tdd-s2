<?php

namespace Acme\Http\Controllers;

use Acme\Models\Message;
use Illuminate\Http\Request;
use Acme\Events\NewChatMessage;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json([
            'result' => 'success',
            'messages' => Message::with('user')->get()
        ]);
    }

    public function store(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'body' => $request->body
        ]);

        event(new NewChatMessage($message->load('user')));

        return response()->json([
            'result' => 'success',
            'message' => $message
        ], 201);
    }
}
