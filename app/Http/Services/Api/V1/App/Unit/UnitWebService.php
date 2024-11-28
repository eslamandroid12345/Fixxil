<?php

namespace App\Http\Services\Api\V1\App\Unit;

use App\Http\Services\Api\V1\App\Unit\UnitService;

class UnitWebService extends UnitService
{
    public static function platform(): string
    {
        return 'website';
    }
}
