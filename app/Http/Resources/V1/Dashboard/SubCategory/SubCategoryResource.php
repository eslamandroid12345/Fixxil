<?php

namespace App\Http\Resources\V1\Dashboard\SubCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'is_active' => $this->is_active,
            'category' => $this->category->t('name'),
        ];
    }
}
