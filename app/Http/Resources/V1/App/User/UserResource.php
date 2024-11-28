<?php

namespace App\Http\Resources\V1\App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function __construct($resource, private readonly bool $withToken)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'is_verified' => $this->isVerified,
            'otp_token' => $this->otpToken,
            'token' => $this->when($this->withToken, $this->token()),
            'notifications' => $this->unreadNotifications->count()
        ];
    }
}
