<?php

namespace App\Http\Resources\V1\Dashboard\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'user_name' => $this->user?->name,
            'user_image' => $this->user?->image,
            'status' => $this->status_value,
            'amount' => $this->amount,
            'point_counter' =>$this->point_counter,
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
