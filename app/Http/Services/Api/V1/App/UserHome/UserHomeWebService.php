<?php

namespace App\Http\Services\Api\V1\App\UserHome;

use App\Http\Services\Api\V1\App\UserHome\UserHomeService;

class UserHomeWebService extends UserHomeService
{
    public static function platform(): string
    {
        return 'website';
    }
}
