<?php

namespace App\Repository\Eloquent;

use App\Models\ChatRoomMember;
use App\Repository\ChatRoomMemberRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ChatRoomMemberRepository extends Repository implements ChatRoomMemberRepositoryInterface
{
    protected Model $model;

    public function __construct(ChatRoomMember $model)
    {
        parent::__construct($model);
    }

    public function incrementUnread($room_id) {
        return $this->model::query()
            ->where('chat_room_id', $room_id)
            ->where('user_id', '!=', auth('api-app')->id())
            ->increment('unread_count');
    }

    public function resetUnread($room_id) {
        return $this->model::query()
            ->where('chat_room_id', $room_id)
            ->where('user_id', auth('api-app')->id())
            ->update(['unread_count' => 0]);
    }
}
