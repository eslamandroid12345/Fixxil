<?php

namespace App\Http\Services\Api\V1\App\User;

use App\Http\Services\Api\V1\App\User\UserService;

class UserWebService extends UserService
{
    public static function platform(): string
    {
        return 'website';
    }
    public function sin()
    {

    }
}
