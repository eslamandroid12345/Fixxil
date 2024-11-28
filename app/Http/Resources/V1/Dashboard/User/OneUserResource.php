<?php

namespace App\Http\Resources\V1\Dashboard\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneUserResource extends JsonResource
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
                    'type' => $this->type,
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'about' => $this->about,
                    'governorate' => $this->governorate?->t('name'),
                    'city' => $this->city?->t('name'),
                    'zone' => $this->zone?->t('name'),
                    'national_id' => $this->national_id,
                    'national_id_image' => $this->national_id_image,
                    'criminal_record_sheet' => $this->criminal_record_sheet,
                    'image' => $this->image ?? null,
                    'is_active' => $this->is_active,
                    'is_verified' => $this->is_verified,
                    'wallet' => $this->wallet,
                    'cities' => UserCityResource::collection($this->cities) ?? null,
                    'subCategories' => UserSubCategoryResource::collection($this->subCategories) ?? null,
                    'fixedServices' => UserFixedServicesResource::collection($this->fixedServices) ?? null,
                    'serviceImages' => UserServiceImagesResource::collection($this->serviceImages) ?? null,
                    'workTime' => UserWorkTimeResource::collection($this->workTime) ?? null,
                    'charges' => UserChargeResource::collection($this->walletTransaction) ?? null,
                ];
    }
}
