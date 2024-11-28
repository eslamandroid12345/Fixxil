<?php

namespace App\Http\Services\Api\V1\App\Order;

class OrderMobileService extends OrderService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
