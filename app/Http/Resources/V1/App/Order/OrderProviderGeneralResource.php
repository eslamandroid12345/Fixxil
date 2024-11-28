<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OrderAction;
use App\Http\Enums\OrderStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\City\CityResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use App\Http\Resources\V1\App\Order\OrderForProviderResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProviderGeneralResource extends JsonResource
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
            'is_stopped' => $this->is_stopped,
            'order_number' => $this->order_number,
            'description' => $this->description,
            'price' => $this->price ?? null,
            'at' => $this->at ? Carbon::parse($this->at)->format('Y-m-d g:i') : null,
            'status' => $this->status,
            'importance' => $this->importance,
            'can_add_review' => $this->canAddReview,
            'can_go_to_location' => $this->canGoToLocation,
            'can_start_service' => $this->canStartService,
            'can_finish_service' => $this->canFinishService,
            'can_offer_price' => $this->canOfferPrice,
            'can_accept_order' => $this->canAcceptOrder,
            'can_cansel_order' => $this->canCanselOrder,
            'can_request_discount' => $this->canRequestDiscount,
            'can_discount' => $this->canDiscount,
            'can_fix_the_price' => $this->canFixThePrice,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'one_order' => new OrderForProviderResource($this),
            'my_offers' => OfferResource::collection($this->offers),
            'offer_exist' => $this->offerExist,
            'offers_counter' => $this->offers?->count(),
        ];
    }
}
