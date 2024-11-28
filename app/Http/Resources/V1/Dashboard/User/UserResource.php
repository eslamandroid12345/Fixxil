<?php

namespace App\Http\Resources\V1\Dashboard\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                    'type' => $this->type,
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'image' => $this->image ?? null,
                    'is_active' => $this->is_active,
                    'date' => $this->created_at->format('Y-m-d g:i'),
                ];
    }
}
