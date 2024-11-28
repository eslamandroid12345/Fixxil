<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OrderAction;
use App\Http\Enums\OrderStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'provider' => new ProviderResource($this->provider),
            'status' => new EnumableResource(OrderStatus::from($this->status)),
            'action' => $this->action ? new EnumableResource(OrderAction::from($this->action)) : null,
            'at' => $this->at,
            'price' => $this->price,
            'has_discount_before' => $this->has_discount_before,
            'sub_category' => new SubCategoryResource($this->subCategory),
            'city' => new CityResource($this->city),
            'zone' => $this->zone,
            'address' => $this->address,
            'description' => $this->description,
            'description_image' => OrderImageResource::collection($this->images),
        ];
    }
}
