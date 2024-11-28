<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OrderStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderForUserResource extends JsonResource
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
                    'status' => new EnumableResource(OrderStatus::from($this->status)),
                    'provider_name' => $this->provider?->name,
                    'provider_image' => $this->provider?->image ?? null,
                    'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
