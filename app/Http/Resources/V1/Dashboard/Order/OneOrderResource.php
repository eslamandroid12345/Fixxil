<?php

namespace App\Http\Resources\V1\Dashboard\Order;

use App\Http\Resources\V1\Dashboard\Chat\ChatMessageResource;
use App\Http\Resources\V1\Dashboard\User\UserCityResource;
use App\Http\Resources\V1\Dashboard\User\UserFixedServicesResource;
use App\Http\Resources\V1\Dashboard\User\UserServiceImagesResource;
use App\Http\Resources\V1\Dashboard\User\UserSubCategoryResource;
use App\Http\Resources\V1\Dashboard\User\UserWorkTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneOrderResource extends JsonResource
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
            'order_number' => $this->orderNumberDashboard,
            'customer' => $this->customer?->name,
            'provider' => $this->provider?->name,
            'status' => $this->status,
            'action' => $this->action,
            'at' => $this->at,
            'price' => $this->priceTitle,
            'sub_category' => $this->subCategory?->t('name'),
            'city' => $this->city->t('name'),
            'zone' => $this->zone->t('name'),
            'address' => $this->address,
            'description' => $this->description,
            'importance' => $this->importance,
            'message_count' => $this->messages->count(),
            'description_image' => OrderImageResource::collection($this->images),
            'messages' => ChatMessageResource::collection($this->whenLoaded('messages'))
        ];
    }
}
