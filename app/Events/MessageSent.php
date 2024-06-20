<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $receiver;
    public $sender;
    public $message;

    public function __construct($receiver, $sender, $message)
    {
        $this->receiver = [
            'id' => $receiver->id,
            'name' => $receiver->name,
            'role' => $receiver->role,
        ];

        $this->sender = [
            'id' => $sender->id,
            'name' => $sender->name,
            'role' => $sender->role,
        ];

        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('chat.' . $this->receiver['id']);
    }
}
