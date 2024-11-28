<?php

namespace App\Http\Services\Api\V1\App\City;

use App\Http\Services\Api\V1\App\City\CityService;

class CityWebService extends CityService
{
    public static function platform(): string
    {
        return 'website';
    }
}
