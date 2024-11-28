<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OrderStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewOrdersCustomerResource extends JsonResource
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
            'order_number' => $this->order_number,
            'provider_id' => $this->provider_id,
            'customer_id' => $this->customer_id,
            'description' => $this->description,
            'importance' => $this->importance,
            'status' => new EnumableResource(OrderStatus::from($this->status)),
            'name' => $this->provider?->name,
            'image' => $this->provider?->image ?? null,
            'is_verified' => $this->provider?->is_verified,
            'sub_category' => new SubCategoryResource($this->subCategory),
            'date' => Carbon::parse($this->created_at)->diffForHumans(),
            'at' => $this->at ? Carbon::parse($this->at)->format('Y-m-d g:i') : null,
        ];
    }
}
