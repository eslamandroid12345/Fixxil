<?php

namespace App\Http\Services\Api\V1\App\Negotiates;

class NegotiatesMobileService extends NegotiatesService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
