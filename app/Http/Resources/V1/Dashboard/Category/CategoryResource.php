<?php

namespace App\Http\Resources\V1\Dashboard\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'show_home' => $this->show_home,
            'is_active' => $this->is_active,
            'image' => $this->image,
        ];
    }
}
