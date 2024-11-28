<?php

namespace App\Http\Services\Api\V1\App\Info;

use App\Http\Services\Api\V1\App\Info\InfoService;

class InfoWebService extends InfoService
{
    public static function platform(): string
    {
        return 'website';
    }
}
