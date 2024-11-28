<?php

namespace App\Http\Resources\V1\App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositDetailsResource extends JsonResource
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
                    'point_count' => $this->point_counter,
                    'date' => $this->date,
                ];
    }
}
