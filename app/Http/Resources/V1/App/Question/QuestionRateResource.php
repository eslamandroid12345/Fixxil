<?php

namespace App\Http\Resources\V1\App\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionRateResource extends JsonResource
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
                    'question' => $this->question?->t('question'),
                    'order' => $this->order->id,
                    'rate' => $this->rate,
                    'answer' => $this->answer ?? null,
                ];
    }
}
