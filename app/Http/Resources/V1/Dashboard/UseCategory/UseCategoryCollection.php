<?php

namespace App\Http\Resources\V1\Dashboard\UseCategory;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UseCategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content' => $this->collection,
            'pagination' => new PaginationResource($this),
        ];
    }
}
