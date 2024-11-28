<?php

namespace App\Http\Traits;

use App\Jobs\FireBaseJob;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait Notification
{
    public function SendNotification($notificationClass, $users = [], $paramters = [])
    {
        try {
            if ($users instanceof Collection) {
                $fcms = $users->pluck('fcm');
                $users = $users->all();
            }
            $fcms = is_array($users) ? $fcms : [$users->fcm];
            $users = is_array($users) ? $users : [$users];
            $notification = new $notificationClass($paramters);
            dispatch(new FireBaseJob($notification->firebaseData(), $fcms));
            foreach ($users as $user) {
                if ($user && method_exists($user, 'notify')) {
                    $user->notify($notification);
                }
            }
        } catch (\Exception $exception) {
            Log::error('Notification Error : ' . $exception);
        }
    }
}
