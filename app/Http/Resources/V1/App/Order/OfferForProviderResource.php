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

class OfferForProviderResource extends JsonResource
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
                    'status' => new EnumableResource(OfferStatus::from($this->offers()->latest()->first()->status)),
                    'customer' => new ProviderResource($this->customer),
                    'description' => $this->description,
                    'count' => $this->offers()->count(),
                    'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
