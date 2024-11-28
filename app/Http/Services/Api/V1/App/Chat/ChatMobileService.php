<?php

namespace App\Http\Services\Api\V1\App\Chat;


use App\Http\Services\Api\V1\App\Chat\ChatService;

class ChatMobileService extends ChatService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
