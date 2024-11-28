<?php

namespace App\Http\Resources\V1\Dashboard\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWorkTimeResource extends JsonResource
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
            'day' => $this->t('day'),
            'from' => Carbon::parse($this->from)->format('g:i a'),
            'to' => Carbon::parse($this->to)->format('g:i a'),
        ];
    }
}
