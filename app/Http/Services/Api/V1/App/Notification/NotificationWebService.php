<?php

namespace App\Http\Services\Api\V1\App\Notification;

class NotificationWebService extends NotificationService
{
    public static function platform(): string
    {
        return 'website';
    }
}
