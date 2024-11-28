<?php

namespace App\Http\Resources\V1\App\User;

use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserHomeResource extends JsonResource
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
            'is_verified' => $this->is_verified,
            'name' => $this->name,
            'image' => $this->image ?? null,
            'city' => $this->city?->t('name'),
            'rate' => $this->averageRate ?? 0,
            'rateusers' => $this->questionRateProviderCount(),
//                    'subcategory' => SubCategoryResource::collection($this->subCategories),
            'subcategory' => $this->subcategory?->first()?->t('name'),
        ];
    }
}
