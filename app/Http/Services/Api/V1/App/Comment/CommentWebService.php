<?php

namespace App\Http\Services\Api\V1\App\Comment;

use App\Http\Services\Api\V1\App\Comment\CommentService;

class CommentWebService extends CommentService
{
    public static function platform(): string
    {
        return 'website';
    }
}
