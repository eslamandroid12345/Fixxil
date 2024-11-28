<?php

namespace App\Http\Services\Api\V1\App\Notification;

use App\Http\Resources\V1\App\Notification\NotifactionCollection;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\NotificationRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Notification\NotificationResource;

abstract class NotificationService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly NotificationRepositoryInterface $notificationRepository,
        private readonly UserRepositoryInterface         $userRepository,
        private readonly FileManagerService              $fileManagerService,
        private readonly GetService                      $getService,
    )
    {
    }


    public function getNotificationsForUser()
    {
        $user = $this->userRepository->getById(auth('api-app')->id());
        return $this->getService->handle(NotifactionCollection::class, $this->notificationRepository, 'getMyNotifications', is_instance: true);
    }

    public function readNotificationsForUser()
    {
        $id = auth('api-app')->id();
        $notifications = $this->notificationRepository->get('notifiable_id', $id);
        foreach ($notifications as $notification) {
            $this->notificationRepository->update($notification->id, ['read_at' => Carbon::now()]);
        }
        return $this->responseSuccess(message: __('messages.updated successfully'));
    }

    public function deleteNotificationsForUser()
    {
        $id = auth('api-app')->id();
        $notifications = $this->notificationRepository->get('notifiable_id', $id);
        foreach ($notifications as $notification) {
            $notification->delete();
        }
        return $this->responseSuccess(message: __('messages.deleted successfully'));
    }

    public function readNotificationForUser($id)
    {
        $notification = $this->notificationRepository->getNotification($id)->first();
        $notification->markAsRead();
        return $this->responseSuccess(message: __('messages.updated successfully'));
    }

}
