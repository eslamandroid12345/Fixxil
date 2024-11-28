<?php

namespace App\Http\Controllers\Api\V1\App\Notification;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Notification\NotificationService;

class NotificationController extends Controller
{
    public function __construct(
        private readonly NotificationService $notification,
    )
    {
        $this->middleware('auth:api-app');
    }

    public function getNotificationsForUser()
    {
        return $this->notification->getNotificationsForUser();
    }
    public function readNotificationsForUser()
    {
        return $this->notification->readNotificationsForUser();
    }
    public function deleteNotificationsForUser()
    {
        return $this->notification->deleteNotificationsForUser();
    }
    public function readNotificationForUser($id)
    {
        return $this->notification->readNotificationForUser($id);
    }

}
