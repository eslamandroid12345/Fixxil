<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OfferStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferGeneralResource extends JsonResource
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
            'price' => $this->priceTitle,
            'status' => OfferStatus::from($this->status)->t(),
            'status_type' => $this->status ,
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
