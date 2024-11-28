<?php

namespace App\Http\Resources\V1\App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image ?? null,
            'city' => $this->city?->t('name'),
            'rate' => $this->averageRate ?? 0,
            'subcategory' => $this->subcategory?->first()?->t('name'),
            'is_verified' => $this->is_verified,
        ];
    }
}
