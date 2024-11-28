<?php

namespace App\Http\Resources\V1\App\Order;

use App\Http\Enums\OfferStatus;
use App\Http\Enums\OrderStatus;
use App\Http\Resources\EnumableResource;
use App\Http\Resources\V1\App\User\ProviderResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneOrderHasOfferResource extends JsonResource
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
            'provider_id' => $this->provider_id,
            'description' => $this->description,
            'is_stopped' => $this->is_stopped,
            'importance' => $this->importance,
            'status' => new EnumableResource(OrderStatus::from($this->status)),
            'offer_numbers' => $this->offers->count(),
            'date' => $this->created_at->format('Y-m-d g:i'),
            'at' => $this->at ? Carbon::parse($this->at)->format('Y-m-d g:i') : null,
            'offers' => OfferResource::collection($this->offers),
        ];
    }
}
