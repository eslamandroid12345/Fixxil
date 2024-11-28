<?php

namespace App\Http\Services\Api\V1\App\Info;


use App\Http\Services\Api\V1\App\Info\InfoService;

class InfoMobileService extends InfoService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
