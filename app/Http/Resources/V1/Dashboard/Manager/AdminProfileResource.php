<?php

namespace App\Http\Resources\V1\Dashboard\Manager;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'image' => $this->image,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'notification_count' => $this->unreadNotifications->count(),
                ];
    }
}
