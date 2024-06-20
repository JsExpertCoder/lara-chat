<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatMessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'from' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create($validatedData);
        $receiver = User::find($request->user_id);
        $sender = User::find($request->from);

        // broadcast(new MessageSent($receiver, $sender, $request->message));
        MessageSent::dispatch($receiver, $sender, $message);

        return response([
            'status' => 200,
            'type' => 'success',
            'title' => 'Feedback 👋',
            'message' => '✅ message sent',
            'data' => [
                'sender' => $sender,
                'message' =>  $message,
                'receiver' => $receiver
            ]
        ]);
    }

    /**
     * Get the messages for the user along with messages count.
     */
    public function getUnreadMessages(Request $request): Collection
    {
        return ChatMessage::with('from')->where('user_id', $request->user_id)
            ->get();
    }
}
