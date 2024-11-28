<?php

namespace App\Http\Services\Api\V1\App\User;


use App\Http\Services\Api\V1\App\User\UserService;

class UserMobileService extends UserService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
