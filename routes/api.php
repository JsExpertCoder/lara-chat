<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\_Auth;
use App\Http\Controllers\API\ChatMessageController;

Route::post('login', [_Auth::class, 'login']);

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {

    // Route::get('get-unread-messages', [ChatMessageController::class, 'getUnreadMessages']);

    // Route::post('/get-team-members', [TeamController::class, 'index']);

    Route::post('send-message', [ChatMessageController::class, 'store']);
});
