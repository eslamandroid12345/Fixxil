<?php

namespace App\Repository;

interface ChatRoomMemberRepositoryInterface extends RepositoryInterface
{
    public function incrementUnread($room_id);

    public function resetUnread($room_id);
}
