<?php

namespace App\Http\Resources\V1\App\Review;

use App\Http\Resources\V1\App\Order\OrderReviewResource;
use App\Http\Resources\V1\Dashboard\User\UserSubCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderReviewResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'is_verified' => $this->is_verified,
        ];
    }
}
