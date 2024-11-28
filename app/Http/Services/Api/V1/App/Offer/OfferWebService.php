<?php

namespace App\Http\Services\Api\V1\App\Offer;

use App\Http\Services\Api\V1\App\Offer\OfferService;

class OfferWebService extends OfferService
{
    public static function platform(): string
    {
        return 'website';
    }
}
