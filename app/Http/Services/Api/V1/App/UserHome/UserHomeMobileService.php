<?php

namespace App\Http\Services\Api\V1\App\UserHome;


use App\Http\Services\Api\V1\App\UserHome\UserHomeService;

class UserHomeMobileService extends UserHomeService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
