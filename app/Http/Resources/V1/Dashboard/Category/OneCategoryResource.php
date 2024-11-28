<?php

namespace App\Http\Resources\V1\Dashboard\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneCategoryResource extends JsonResource
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
            'show_home' => $this->show_home,
            'is_active' => $this->is_active,
            'image' => $this->image,
            'indexx' => $this->indexx,
        ];
    }
}
