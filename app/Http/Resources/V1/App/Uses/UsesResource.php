<?php

namespace App\Http\Resources\V1\App\Uses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsesResource extends JsonResource
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
            'name' => $this->t('name'),
            'description' => $this->t('description'),
            'video_link' => $this->whenNotNull($this->video_link),
            'questions' => UsesResource::collection($this->whenLoaded('children')),
        ];
    }
}
