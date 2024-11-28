<?php

namespace App\Repository;

interface ChatRoomMessageRepositoryInterface extends RepositoryInterface
{
    public function getRoomMessages($room_id, $after_message_id = null);
}
