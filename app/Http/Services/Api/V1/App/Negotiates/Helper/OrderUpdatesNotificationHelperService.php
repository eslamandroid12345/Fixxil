<?php

namespace App\Http\Services\Api\V1\App\Negotiates\Helper;

use App\Http\Traits\Notification;
use App\Notifications\OrderUpdateNotification;
use Illuminate\Support\Facades\Log;

class OrderUpdatesNotificationHelperService
{
    use Notification;

    public function sendOrderUpdateNotification($order, $message = '')
    {
        if ($order->provider_id == auth('api-app')->id())
            $otherPerson = $order->customer;
        else if ($order->customer_id == auth('api-app')->id())
            $otherPerson = $order->provider;
        $this->SendNotification(OrderUpdateNotification::class, $otherPerson, [
            'order_id' => $order->id,
            'message' => $message,
        ]);
    }
}
