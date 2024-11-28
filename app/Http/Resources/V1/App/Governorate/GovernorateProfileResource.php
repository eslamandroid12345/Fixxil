<?php

namespace App\Http\Resources\V1\App\Governorate;

use App\Http\Resources\V1\App\City\CityProfileResource;
use App\Http\Resources\V1\App\City\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GovernorateProfileResource extends JsonResource
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
            'cities' => CityProfileResource::collection($this->cities),
        ];
    }
}
