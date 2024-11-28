<?php

namespace App\Http\Services\Api\V1\App\Blog;


class BlogMobileService extends BlogService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
