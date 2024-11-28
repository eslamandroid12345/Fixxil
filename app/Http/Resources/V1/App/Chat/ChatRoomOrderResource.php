<?php

namespace App\Http\Resources\V1\App\Chat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomOrderResource extends JsonResource
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
            'status' => $this->status,
            'has_message' => $this->hasMessage,
            'other_party' => new SimpleUserResource($this->otherParty?->user),
            'messages' => ChatMessageResource::collection($this->messages),
        ];
    }
}
