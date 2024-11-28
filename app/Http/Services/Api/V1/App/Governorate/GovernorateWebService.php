<?php

namespace App\Http\Services\Api\V1\App\Governorate;

use App\Http\Services\Api\V1\App\Governorate\GovernorateService;

class GovernorateWebService extends GovernorateService
{
    public static function platform(): string
    {
        return 'website';
    }
}
