<?php

namespace App\Http\Resources\V1\Dashboard\Notification;
use App\Http\Resources\V1\App\User\ProviderResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'content' => $this->data[$locale],
            'is_read' => $this->is_read,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y g:ia'),
        ];
    }
}
