<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OrderStatus;
use App\Http\Enums\OfferStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
                    'status' => new EnumableResource(OfferStatus::from($this->status)),
                    'provider' => new ProviderResource($this->provider),
                    'price' => $this->priceTitle,
                    'at' => $this->at,
                    'sub_category' => $this->order->subCategory->t('name'),
                    'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
