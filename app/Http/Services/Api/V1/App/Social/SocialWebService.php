<?php

namespace App\Http\Services\Api\V1\App\Social;

use App\Http\Services\Api\V1\App\Social\SocialService;

class SocialWebService extends SocialService
{
    public static function platform(): string
    {
        return 'website';
    }
}
