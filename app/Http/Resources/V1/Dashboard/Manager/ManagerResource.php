<?php

namespace App\Http\Resources\V1\Dashboard\Manager;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
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
            'image' => $this->image ?? null,
            'token' => $this->when($this->withToken, $this->token()),
            'permissions' => PermissionResource::collection($this->permissionsAdmin()),
            'notifications' => $this->unreadNotifications->count()
        ];
    }
}
