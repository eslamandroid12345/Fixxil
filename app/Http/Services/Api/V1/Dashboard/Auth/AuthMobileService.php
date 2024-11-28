<?php

namespace App\Http\Services\Api\V1\Dashboard\Auth;

class AuthMobileService extends AuthService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
