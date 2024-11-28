<?php

namespace App\Http\Resources\V1\Dashboard\Info;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->type == 'text')
        {
            return [
                        'id' => $this->id,
                        'name' => $this->t('name'),
                        'key' => $this->key,
                        'value' => $this->value,
                        'type' => $this->type,
                    ];
        }
        else
        {
            return [
                        'id' => $this->id,
                        'name' => $this->t('name'),
                        'key' => $this->key,
                        'value' => url($this->value),
                        'type' => $this->type,
                    ];
        }

    }
}
