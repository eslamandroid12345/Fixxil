<?php

namespace App\Http\Resources\V1\App\City;

use App\Http\Resources\V1\App\Zone\ZoneResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityProfileResource extends JsonResource
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
            'name' => $this->t('name'),
            'choosed' => $this->choosed,
            'zones' => ZoneResource::collection($this->zones),
        ];
    }
}
