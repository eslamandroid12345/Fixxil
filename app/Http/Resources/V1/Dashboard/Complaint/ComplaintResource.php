<?php

namespace App\Http\Resources\V1\Dashboard\Complaint;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'from' => $this->fromUser->name,
            'to' => $this->toUser->name,
            // 'order' => $this->order_id,
            'order_number' => $this->order->order_number,
            'complaint' => $this->complaint,
            'status' => $this->status_value,
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
