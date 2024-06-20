<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\User;

Broadcast::channel('chat.{receiverId}', function (User $user, int $receiverId) {
    return (int) $user->id === (int) $receiverId;
});
