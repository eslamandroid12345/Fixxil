<?php

namespace App\Http\Resources\V1\Dashboard\Changes;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChangesCollection extends ResourceCollection
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
