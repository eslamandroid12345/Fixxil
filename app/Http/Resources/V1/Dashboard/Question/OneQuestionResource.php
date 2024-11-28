<?php

namespace App\Http\Resources\V1\Dashboard\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneQuestionResource extends JsonResource
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
                    'question_ar' => $this->question_ar,
                    'question_en' => $this->question_en,
                    'is_active' => $this->is_active,
                ];
    }
}