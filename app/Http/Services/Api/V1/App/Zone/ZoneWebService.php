<?php

namespace App\Http\Services\Api\V1\App\Zone;

use App\Http\Services\Api\V1\App\Zone\ZoneService;

class ZoneWebService extends ZoneService
{
    public static function platform(): string
    {
        return 'website';
    }
}
