<?php

namespace App\Http\Services\Api\V1\App\Negotiates;

class NegotiatesWebService extends NegotiatesService
{
    public static function platform(): string
    {
        return 'website';
    }
}
