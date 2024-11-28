<?php

namespace App\Http\Services\Api\V1\App\Unit;


use App\Http\Services\Api\V1\App\Unit\UnitService;

class UnitMobileService extends UnitService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
