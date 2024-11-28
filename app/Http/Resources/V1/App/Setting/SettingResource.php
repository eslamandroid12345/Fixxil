<?php

namespace App\Http\Resources\V1\App\Setting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
                    'name' => $this->t('name'),
                    'about' => $this->t('about'),
                    'policy' => $this->t('policy'),
                    'facbook' => $this->facbook,
                    'linkedin' => $this->linkedin,
                    'youtube' => $this->youtube,
                    'insta' => $this->insta,
                    'twiter' => $this->twiter,
                    'tiktok' => $this->tiktok,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'whatsapp' => $this->whatsapp,
                    'address' => $this->address,
                ];
    }
}
