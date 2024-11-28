<?php

namespace App\Http\Services\Api\V1\App\Notification;


class NotificationMobileService extends NotificationService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
