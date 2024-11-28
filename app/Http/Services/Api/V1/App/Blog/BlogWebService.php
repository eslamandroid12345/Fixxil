<?php

namespace App\Http\Services\Api\V1\App\Blog;

class BlogWebService extends BlogService
{
    public static function platform(): string
    {
        return 'website';
    }
}
