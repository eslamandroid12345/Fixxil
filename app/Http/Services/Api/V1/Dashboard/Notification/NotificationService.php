<?php

namespace App\Http\Services\Api\V1\Dashboard\Notification;

use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\NotificationRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\Dashboard\Notification\NotificationResource;

class NotificationService
{
    use Responser;

    public function __construct(
        private readonly NotificationRepositoryInterface $notificationRepository,
        private readonly ManagerRepositoryInterface $managerRepository,
        private readonly FileManagerService              $fileManagerService,
        private readonly GetService                      $getService,
    )
    {
    }


    public function readNotificationsForAdmin()
    {
        $id = auth('api-manager')->id();
        $manager = $this->managerRepository->getById($id);
        $manager->unreadNotifications->markAsRead();
        return $this->getService->handle(NotificationResource::class, $this->notificationRepository, 'getNotificationsForAdmin', parameters: [$id]);
    }

    public function readNotificationForAdmin()
    {
        $id = auth('api-manager')->id();
        $notification = $this->notificationRepository->getNotification($id)->first();
        $notification->markAsRead();
        return $this->responseSuccess(message: __('messages.updated successfully'));
    }

}
