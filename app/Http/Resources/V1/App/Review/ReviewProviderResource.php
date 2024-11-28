<?php

namespace App\Http\Resources\V1\App\Review;

use App\Http\Resources\V1\App\Order\OrderReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewProviderResource extends JsonResource
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
            'comment' => $this->comment ?? null,
            'average_rate' => $this->rates_avg_rate ?? 0,
            'order' => OrderReviewResource::make($this->order),
            'customer' => CustomerReviewResource::make($this->customer),
            'date' => $this->created_at->format('Y-m-d g:i'),        ];
    }
}
