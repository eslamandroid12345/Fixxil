<?php

namespace App\Http\Resources\V1\Dashboard\UsesQuestion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneUsesQuestionResource extends JsonResource
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
                    'name_ar' => $this->name_ar,
                    'name_en' => $this->name_en,
                    'description_en' => $this->description_en,
                    'description_ar' => $this->description_ar,
                    'indexx' => $this->indexx,
                ];
    }
}
