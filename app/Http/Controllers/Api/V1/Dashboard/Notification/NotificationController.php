<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Notification;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Notification\NotificationService;

class NotificationController extends Controller
{
    public function __construct(
        private readonly NotificationService $notification,
    )
    {
        $this->middleware('auth:api-manager');
    }

    public function readNotificationsForAdmin()
    {
        return $this->notification->readNotificationsForAdmin();
    }
    public function readNotificationForAdmin($id)
    {
        return $this->notification->readNotificationForAdmin($id);
    }

}
