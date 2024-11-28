<?php

namespace App\Http\Services\Api\V1\Dashboard\Auth;

class AuthWebService extends AuthService
{
    public static function platform(): string
    {
        return 'website';
    }
}
