<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OrderStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderNotHaveOfferResource extends JsonResource
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
            'description' => $this->description,
            'customer_id' => $this->customer?->id,
            'customer_name' => $this->customer?->name,
            'customer_image' => $this->customer?->image ?? null,
            'customer_city' => $this->customer?->city->t('name'),
            'offer_numbers' => $this->offers->count(),
            'offer_exist' => $this->offerExist,
            'importance' => $this->importance,
            'is_stopped' => $this->is_stopped,
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
