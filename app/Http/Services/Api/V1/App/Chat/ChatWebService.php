<?php

namespace App\Http\Services\Api\V1\App\Chat;

use App\Http\Services\Api\V1\App\Chat\ChatService;

class ChatWebService extends ChatService
{
    public static function platform(): string
    {
        return 'website';
    }
}
