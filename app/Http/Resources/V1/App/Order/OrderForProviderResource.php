<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OrderAction;
use App\Http\Enums\OrderStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderForProviderResource extends JsonResource
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
            'customer' => new ProviderResource($this->customer),
            'provider_id' => $this->provider_id,
            'customer_id' => $this->customer_id,
            'status' => new EnumableResource(OrderStatus::from($this->status)),
            'action' => $this->action ? new EnumableResource(OrderAction::from($this->action)) : null,
//            'at' => Carbon::parse($this->at)->format('Y-m-d g:i'),
            'at' => $this->at ? Carbon::parse($this->at)->format('Y-m-d g:i') : null,
            'price' => $this->price,
            'has_discount_before' => $this->has_discount_before,
            'sub_category' => new SubCategoryResource($this->subCategory),
            'city' => new CityResource($this->city),
            'zone' => $this->zone->t('name'),
            'address' => $this->address . ' - ' . $this->zone->t('name') . ' - ' . $this->city->t('name'),
            'description' => $this->description,
            'description_image' => OrderImageResource::collection($this->images),
            // 'date' => $this->at->format('Y-m-d g:i'),
            'date' => Carbon::parse($this->at)->format('Y-m-d g:i'),
        ];
    }
}
