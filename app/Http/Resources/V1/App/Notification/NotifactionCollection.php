<?php

namespace App\Http\Resources\V1\App\Notification;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotifactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content' => NotificationResource::collection($this->collection) ,
            'meta' => PaginationResource::make($this) ,
        ];
    }
}
