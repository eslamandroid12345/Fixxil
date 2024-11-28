<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderReviewResource extends JsonResource
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
            'price' => $this->price,
            'sub_category' => $this->subCategory?->t('name'),
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
