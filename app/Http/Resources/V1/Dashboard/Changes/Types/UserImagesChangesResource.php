<?php

namespace App\Http\Resources\V1\Dashboard\Changes\Types;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserImagesChangesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => url($this->path)
        ];
    }
}
