<?php

namespace App\Http\Services\Api\V1\App\CustomerReview;



class CustomerReviewMobileService extends CustomerReviewService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
