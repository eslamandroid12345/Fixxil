<?php

namespace App\Http\Resources\V1\App\Review;

use App\Http\Resources\V1\App\Order\OrderReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewCustomerResource extends JsonResource
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
            'rated' => $this->rated,
            'comment' => $this->comment ?? null,
            'average_rate' => $this->rates_avg_rate ?? 0,
            'order' => OrderReviewResource::make($this->order),
            'provider' => ProviderReviewResource::make($this->provider),
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
