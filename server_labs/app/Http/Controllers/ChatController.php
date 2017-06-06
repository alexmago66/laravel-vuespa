<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use Vinkla\Pusher\Facades\Pusher as LaravelPusher;

class ChatController extends Controller
{
  public function getUserConversationById(Request $request) {
    $userId = $request->input('id');
    $authUserId = $request->input('authId');
    $chats = Chat::whereIn('sender_id', [$authUserId, $userId])->whereIn('receiver_id', [$userId, $authUserId])->orderBy('created_at', 'asc')->get();
    return response(['data' => $chats], 200);
  }

  public function saveUserChat(Request $request) {
    $data = [
      'sender_id' => $request->sender_id,
      'receiver_id' => $request->receiver_id,
      'chat' => $request->chat,
      'read' => 1
    ];
    $chat = Chat::create($data);
    $finalData = Chat::whereId($chat->id)->first();

    LaravelPusher::trigger('chat_channel', 'chat_saved', ['message' => $finalData]);
    return response(['data' => $finalData], 201);
  }
}
