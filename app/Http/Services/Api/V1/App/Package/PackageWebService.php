<?php

namespace App\Http\Services\Api\V1\App\Package;

class PackageWebService extends PackageService
{
    public static function platform(): string
    {
        return 'website';
    }
}
