<?php

namespace App\Repository\Eloquent;

use App\Models\ChatRoomMessage;
use App\Repository\ChatRoomMessageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ChatRoomMessageRepository extends Repository implements ChatRoomMessageRepositoryInterface
{
    protected Model $model;

    public function __construct(ChatRoomMessage $model)
    {
        parent::__construct($model);
    }

    public function getRoomMessages($room_id, $after_message_id = null)
    {
        return $this->model::query()
            ->where('chat_room_id', $room_id)
            ->where(function ($query) use ($after_message_id) {
                if ($after_message_id !== null)
                    $query->where('id', '<', $after_message_id);
            })
            ->orderByDesc('id')
            ->limit(20)
            ->get()
            ->sortBy('id');
    }
}
