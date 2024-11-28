<?php

namespace App\Http\Resources\V1\App\User;

use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LastInteractionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
                    'id' => $this->id,
                    'user' => new ProviderResource($this->user),
                    'comment' => $this->comment,
            ];
    }
}
