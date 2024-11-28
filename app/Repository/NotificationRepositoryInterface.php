<?php

namespace App\Repository;

interface NotificationRepositoryInterface extends RepositoryInterface
{
    public function getNotificationsForUser();
    public function getNotificationsForAdmin($id);
    public function getMyNotifications();
    public function getNotification($id);
}
