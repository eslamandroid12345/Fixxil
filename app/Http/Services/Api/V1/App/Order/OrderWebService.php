<?php

namespace App\Http\Services\Api\V1\App\Order;

class OrderWebService extends OrderService
{
    public static function platform(): string
    {
        return 'website';
    }
}
