<?php

namespace App\Http\Resources\V1\App\User;

use App\Http\Resources\V1\Dashboard\User\UserCityResource;
use App\Http\Resources\V1\Dashboard\User\UserFixedServicesResource;
use App\Http\Resources\V1\Dashboard\User\UserServiceImagesResource;
use App\Http\Resources\V1\Dashboard\User\UserSubCategoryResource;
use App\Http\Resources\V1\Dashboard\User\UserWorkTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOneHomeResource extends JsonResource
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
            'subcategory' => $this->subcategory?->first()?->t('name'),
            'city' => $this->city?->t('name'),
            'national_id' => $this->national_id ?? null,
            'national_id_image' => $this->national_id_image ?? null,
            'criminal_record_sheet' => $this->criminal_record_sheet ?? null,
            'image' => $this->image ?? null,
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified,
            'interactive' => $this->last_seen,
            'ratecount' => $this->averageRate ?? 0,
            // 'orders' => $this->ordersAsProviderCounter(),
            'orders' => $this->type == 'provider' ? $this->ordersAsProviderFinished() : $this->ordersAsCustomerFinished(),
            'rateusers' => $this->questionRateProviderCount(),
            'userselected' => $this->ordersAsProviderCounter(),
            'rates' => UserRateResource::collection($this->questionRateProviders()->latest()->limit(3)->get()),
            'cities' => UserCityResource::collection($this->cities),
            'subCategories' => UserSubCategoryResource::collection($this->subCategories),
            'fixedServices' => UserFixedServicesResource::collection($this->fixedServices),
            'serviceImages' => UserServiceImagesResource::collection($this->serviceImages),
            'workTime' => UserWorkTimeResource::collection($this->workTime),
            'last_interaction' => LastInteractionResource::collection($this->getLastThreeComments),
        ];
    }
}
