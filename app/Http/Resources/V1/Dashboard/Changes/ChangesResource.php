<?php

namespace App\Http\Resources\V1\Dashboard\Changes;

use App\Http\Enums\ChangeTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChangesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'type_title' => ChangeTypeEnum::from($this->type)->t() ,
            'type' => $this->type ,
            'user_name' => $this->user?->name ,
        ];
    }
}
