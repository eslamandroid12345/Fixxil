<?php

namespace App\Http\Resources\V1\Dashboard\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFixedServicesResource extends JsonResource
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
                    'unit' => $this->unit->t('name'),
                    'unit_id' => $this->unit->id,
                    'price' => $this->price,
                ];
    }
}
