<?php

namespace App\Http\Resources\V1\Dashboard\City;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneCityResource extends JsonResource
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
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'is_active' => $this->is_active,
            'governorate' => $this->governorate->t('name'),
            'governorate_id' => $this->governorate_id,
        ];
    }
}
