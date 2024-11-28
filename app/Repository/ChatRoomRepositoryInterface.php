<?php

namespace App\Repository;

interface ChatRoomRepositoryInterface extends RepositoryInterface
{
    public function provide($user_id,$order_id);

    public function getRooms();
    public function getRoomByOrder($order_id);
    }
