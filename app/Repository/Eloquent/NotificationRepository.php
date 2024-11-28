<?php

namespace App\Repository\Eloquent;

use App\Models\Notification;
use App\Repository\NotificationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NotificationRepository extends Repository implements NotificationRepositoryInterface
{
    protected Model $model;

    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function getMyNotifications()
    {
        return $this->model->where('notifiable_id', auth('api-app')->id())->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getNotificationsForAdmin($id)
    {
//        return $this->model->where('notifiable_id', $id)->orderBy('created_at', 'desc')->get();

        return $this->model->where('notifiable_id', $id)->latest()->get();
    }

    public function getNotification($id)
    {
        return $this->model->where('id', $id)->limit(1)->get();
    }
    public function getNotificationsForUser()
    {
        return $this->model->where('notifiable_id', auth('api-app')->id())->latest()->paginate(10);
    }

}
