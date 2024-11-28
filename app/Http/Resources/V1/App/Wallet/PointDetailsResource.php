<?php

namespace App\Http\Resources\V1\App\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PointDetailsResource extends JsonResource
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
                    'customer_name' => $this->customer->name,
                    'customer_image' => $this->customer->image,
                    'city' => $this->city->t('name'),
                    'message' => 'message to finish',
                    'point_count' => $this->point_counter,
                    'date' => $this->updated_at->format('g:i A'),
                ];
    }
}
