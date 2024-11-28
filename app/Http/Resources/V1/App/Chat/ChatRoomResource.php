<?php

namespace App\Http\Resources\V1\App\Chat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
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
            'other_party' => new SimpleUserResource($this->otherParty?->user),
            'content' => $this->content,
            'sent_at' => Carbon::parse($this->last_seen?->created_at)->format('d M Y g:ia'),
            'unread_count' => $this->unread_count,
        ];
    }
}
