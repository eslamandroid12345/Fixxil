<?php

namespace App\Http\Services\Api\V1\App\Category;



class CategoryMobileService extends CategoryService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
