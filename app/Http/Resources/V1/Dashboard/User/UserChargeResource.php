<?php

namespace App\Http\Resources\V1\Dashboard\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserChargeResource extends JsonResource
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
            'status' => $this->status_value,
            'amount' => $this->amount,
            'point_counter' =>$this->point_counter,
        ];
    }
}
