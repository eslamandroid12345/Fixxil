<?php

namespace App\Http\Controllers\Api\V1\App\Chat;
use App\Http\Requests\Api\V1\App\Chat\ChatRequest;
use App\Http\Requests\Api\V1\App\Chat\LoadMessageRequest;
use App\Http\Requests\Api\V1\App\Chat\ChatMessageRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Chat\ChatService;

class ChatController extends Controller
{
    public function __construct(
        private readonly ChatService $chat,
    )
    {
        $this->middleware('auth:api-app');
    }

    public function provide(ChatRequest $request)
    {
        return $this->chat->provide($request);
    }

    public function getRooms()
    {
        return $this->chat->getRooms();
    }

    public function getMessages($room_id)
    {
        return $this->chat->getMessages($room_id);
    }

    public function loadMoreMessages(LoadMessageRequest $request, $room_id)
    {
        return $this->chat->loadMoreMessages($request, $room_id);
    }

    public function send(ChatMessageRequest $request, $room_id)
    {
        return $this->chat->send($request, $room_id);
    }

    public function read($room_id)
    {
        return $this->chat->read($room_id);
    }

    public function goOnline() {
        return $this->chat->goOnline();
    }

    public function goOffline()
    {
        return $this->chat->goOffline();
    }
}
