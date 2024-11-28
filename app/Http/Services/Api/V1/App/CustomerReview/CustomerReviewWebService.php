<?php

namespace App\Http\Services\Api\V1\App\CustomerReview;

class CustomerReviewWebService extends CustomerReviewService
{
    public static function platform(): string
    {
        return 'website';
    }
}
