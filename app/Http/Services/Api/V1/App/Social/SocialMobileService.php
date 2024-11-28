<?php

namespace App\Http\Services\Api\V1\App\Social;


use App\Http\Services\Api\V1\App\Social\SocialService;

class SocialMobileService extends SocialService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
