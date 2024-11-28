<?php

namespace App\Http\Resources\V1\Dashboard\CustomerReview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneCustomerReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name_ar" => $this->name_ar,
            "name_en" => $this->name_en,
            "job_title_ar" => $this->job_title_ar,
            "job_title_en" => $this->job_title_en,
            "review_ar" => $this->review_ar,
            "review_en" => $this->review_en,
            "image" => $this->imageUrl,
        ];
    }
}
