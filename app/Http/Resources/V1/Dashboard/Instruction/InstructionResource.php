<?php

namespace App\Http\Resources\V1\Dashboard\Instruction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructionResource extends JsonResource
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
                'order_instruction' => $this->t('order_instruction'),
                'order_used' => $this->t('order_used'),
            ];
    }
}
