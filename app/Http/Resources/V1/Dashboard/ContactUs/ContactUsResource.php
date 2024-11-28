<?php

namespace App\Http\Resources\V1\Dashboard\ContactUs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
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
            'user' => $this->user->name ?? null,
            'title' => $this->title,
            'message' => $this->message,
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
