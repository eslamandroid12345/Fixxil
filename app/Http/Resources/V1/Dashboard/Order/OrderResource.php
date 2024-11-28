<?php

namespace App\Http\Resources\V1\Dashboard\Order;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
                    'order_number' => $this->orderNumberDashboard,
                    'customer' => $this->customer->name,
                    'provider' => $this->provider?->name,
                    'status' => $this->status,
                    'action' => $this->action,
                    'at' => $this->at!==null ? Carbon::parse($this->at)->format('Y-m-d g:i') : null ,
                    'price' => $this->price,
                    'is_active' => $this->is_active,
                    'is_stopped' => $this->is_stopped,
                    'importance' => $this->importance,
                    'message_count' => $this->messages->count(),
                ];
    }
}
