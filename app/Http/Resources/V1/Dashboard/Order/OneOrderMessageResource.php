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

class OneOrderMessageResource extends JsonResource
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
            'messages' => ChatMessageResource::collection($this->whenLoaded('messages'))
        ];
    }
}
