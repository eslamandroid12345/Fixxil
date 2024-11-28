<?php

namespace App\Http\Services\Api\V1\App\Package;



class PackageMobileService extends PackageService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
