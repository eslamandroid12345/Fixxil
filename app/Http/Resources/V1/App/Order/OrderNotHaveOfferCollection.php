<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderNotHaveOfferCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content' => OrderNotHaveOfferResource::collection($this->collection),
            'pagination' => new PaginationResource($this),
        ];
    }
}
