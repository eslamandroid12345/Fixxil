<?php

namespace App\Http\Resources\V1\App\User;

use App\Http\Resources\V1\App\Order\NewOrderHomeResource;
use App\Http\Resources\V1\Dashboard\User\UserCityResource;
use App\Http\Resources\V1\Dashboard\User\UserFixedServicesResource;
use App\Http\Resources\V1\Dashboard\User\UserServiceImagesResource;
use App\Http\Resources\V1\Dashboard\User\UserSubCategoryResource;
use App\Http\Resources\V1\Dashboard\User\UserWorkTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
                    'my_orders_count' => $this->my_orders_count,
                    'my_offers_count' => $this->my_offers_count,
                    'can_offer_on_order' => $this->canOfferOnOrder,
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'wallet' => $this->wallet,
                    'about' => $this->about,
                    'governorate_id' => $this->governorate_id,
                    'city_id' => $this->city_id,
                    'zone_id' => $this->zone_id,
                    'city' => $this->city?->t('name'),
                    'national_id' => $this->national_id,
                    'national_id_image' => $this->national_id_image,
                    'criminal_record_sheet' => $this->criminal_record_sheet,
                    'image' => $this->image ?? null,
                    'is_active' => $this->is_active,
                    'is_verified' => $this->is_verified,
//                    'cities' => UserCityResource::collection($this->cities),
//                    'subCategories' => UserSubCategoryResource::collection($this->subCategories),
                    'fixedServices' => UserFixedServicesResource::collection($this->fixedServices),
                    'serviceImages' => UserServiceImagesResource::collection($this->serviceImages),
                    'workTime' => UserWorkTimeResource::collection($this->workTime),
                    'provider_new_orders' => $this->whenLoaded('providerNewOrders' , NewOrderHomeResource::collection($this->providerNewOrders)) ,
                    'notifications' => $this->unreadNotifications->count()
                ];
    }
}
