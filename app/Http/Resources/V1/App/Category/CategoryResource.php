<?php

namespace App\Http\Resources\V1\App\Category;

use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
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
            'image' => $this->image,
            'sub_categories' => SubCategoryResource::collection($this->activeSubCategories),
        ];
    }
}
