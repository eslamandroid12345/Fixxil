<?php

namespace App\Http\Resources\V1\Dashboard\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneUnitResource extends JsonResource
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
                    'name_ar' => $this->name_ar,
                    'name_en' => $this->name_en,
                    'is_active' => $this->is_active,
                ];
    }
}
