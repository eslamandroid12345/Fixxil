<?php

namespace App\Http\Resources\V1\Dashboard\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language = $request->header('Accept-Language');
        if ($language == 'ar') {
            return [
                'id' => $this->id,
                'name' => $this->dispaly_ar,
            ];
        } else {
            return [
                'id' => $this->id,
                'name' => $this->dispaly_en,
            ];
        }
    }
}
