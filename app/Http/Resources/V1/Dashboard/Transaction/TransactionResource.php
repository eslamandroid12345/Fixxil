<?php

namespace App\Http\Resources\V1\Dashboard\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'status' => $this->statusValue,
            'user_name' => $this->wallet?->name,
            'amount' => $this->amount,
            'point_counter' => $this->point_counter,
        ];
    }
}
