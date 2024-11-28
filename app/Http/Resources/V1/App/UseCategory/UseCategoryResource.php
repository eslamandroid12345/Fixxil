<?php

namespace App\Http\Resources\V1\App\UseCategory;

use App\Http\Resources\V1\App\Uses\UsesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UseCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->t('name'),
            'uses' =>  $this->whenLoaded('uses',UsesResource::collection($this->uses)),
        ];
    }
}
