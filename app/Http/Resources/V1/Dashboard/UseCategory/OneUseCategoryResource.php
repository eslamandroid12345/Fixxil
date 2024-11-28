<?php

namespace App\Http\Resources\V1\Dashboard\UseCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneUseCategoryResource extends JsonResource
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
                    'indexx' => $this->indexx,
                ];
    }
}
