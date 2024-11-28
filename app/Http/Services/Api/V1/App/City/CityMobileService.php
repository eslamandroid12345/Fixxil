<?php

namespace App\Http\Services\Api\V1\App\City;


use App\Http\Services\Api\V1\App\City\CityService;

class CityMobileService extends CityService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
