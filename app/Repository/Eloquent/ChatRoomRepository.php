<?php

namespace App\Repository\Eloquent;

use App\Models\ChatRoom;
use App\Repository\ChatRoomRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ChatRoomRepository extends Repository implements ChatRoomRepositoryInterface
{
    protected Model $model;

    public function __construct(ChatRoom $model)
    {
        parent::__construct($model);
    }

    private function roomProvider($user_id, $order_id)
    {
        return $this->model::query()->where('order_id', $order_id)
            ->whereHas('members', function ($query) {
                $query->where('user_id', auth('api-app')?->id());
            })
            ->whereHas('members', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->with('messages');
    }

    public function provide($user_id, $order_id, $status = 'OPEN')
    {
        if ($this->roomProvider($user_id, $order_id)->exists()) {
            return $this->roomProvider($user_id, $order_id)->first();
        } else {
            $room = $this->create(['order_id' => $order_id, 'status' => $status]);
            $room->members()->insert([
                [
                    'chat_room_id' => $room->id,
                    'user_id' => $user_id,
                    'unread_count' => 0
                ],
                [
                    'chat_room_id' => $room->id,
                    'user_id' => auth('api-app')->id(),
                    'unread_count' => 0
                ],
            ]);
            return $room;
        }
    }

    public function getRooms()
    {
        return $this->model::query()
            ->whereHas('members', function ($query) {
                $query->where('user_id', auth('api-app')->id());
            })
            ->orderByDesc('updated_at')
            ->get();
    }

    public function getRoomByOrder($order_id)
    {
        return $this->model::query()
            ->where('order_id', $order_id)
//                ->where('status','CLOSE')
            ->whereHas('members', function ($q) {
                $q->where('user_id', auth('api-app')?->id());
            })->first();
    }

    public function getRoomByOrderNotMember($order_id)
    {
        return $this->model::query()
            ->where('order_id', $order_id)
            ->first();
    }
}
