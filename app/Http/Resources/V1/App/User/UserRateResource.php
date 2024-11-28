<?php

namespace App\Http\Resources\V1\App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRateResource extends JsonResource
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
            'name' => $this->customer?->name,
            'image' => $this->customer?->image,
            'rate' => $this->averageRate ?? 0,
            'comment' => $this->comment ?? '',
        ];
    }
}
