<?php

namespace App\Http\Resources\V1\App\Chat;

use App\Http\Resources\V1\User\SimpleUserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ChatRoomOnlineStateEventResource extends JsonResource
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
            'is_online' => $this->is_online,
        ];
    }
}
