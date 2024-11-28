<?php

namespace App\Http\Resources\V1\Dashboard\ContactUs;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactUsCollection extends ResourceCollection
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
