<?php

namespace App\Http\Resources\V1\Dashboard\Structure;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StructureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language = $request->header('Accept-Language');
        $data = $this[$language];

        return [

//            'content' => $content,
        ];
    }
}
