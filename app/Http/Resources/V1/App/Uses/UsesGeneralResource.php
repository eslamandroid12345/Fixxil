<?php

namespace App\Http\Resources\V1\App\Uses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsesGeneralResource extends JsonResource
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
        ];
    }
}
