<?php

namespace App\Http\Resources\V1\App\CustomerReview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' =>$this->t('name') ,
            'job_title' =>$this->t('job_title') ,
            'review' =>$this->t('review') ,
            'image' => $this->imageUrl ,
        ];
    }
}
