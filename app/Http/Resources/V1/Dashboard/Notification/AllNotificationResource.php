<?php

namespace App\Http\Resources\V1\Dashboard\Notification;
use App\Http\Resources\V1\App\User\ProviderResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        return [
            'notification_count' => $this->unreadNotifications->count(),
            'notification' => NotificationResource::collection($this->notification),
        ];
    }
}
