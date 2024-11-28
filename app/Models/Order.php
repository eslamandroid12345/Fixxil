<?php

namespace App\Models;

use App\Http\Enums\OrderAction;
use App\Http\Enums\OrderNegotiateStatus;
use App\Http\Enums\OrderStatus;
use App\Http\Enums\UserType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    const NOT_STOPPED=0;
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = [];

//    public function descriptionImageUrl(): Attribute
//    {
//        return Attribute::get(fn() => $this->description_image !== null ? url($this->description_image) : null);
//    }

    public function orderNumber(): Attribute
    {
        return Attribute::make(
            get: fn() => '#' . 9999 + $this->id,
        );
    }

    public function orderNumberDashboard(): Attribute
    {
        return Attribute::make(
            get: fn() => 9999 + $this->id,
        );
    }

    public function canAddReview(): Attribute
    {
        return Attribute::get(
            fn() => $this->status == OrderStatus::FINISHED->value &&
                auth('api-app')->user()?->type == UserType::CUSTOMER->value &&
                !$this->review()?->exists()
                && $this->is_stopped == self::NOT_STOPPED
        );
    }

    public function canGoToLocation(): Attribute
    {
        return Attribute::get(
            fn() => $this->provider_id == auth('api-app')->id() &&
                auth('api-app')->user()?->type == UserType::PROVIDER->value &&
                $this->action == null &&
                $this->status == OrderStatus::IN_PROGRESS->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canStartService(): Attribute
    {
        return Attribute::get(
            fn() => $this->provider_id == auth('api-app')->id() &&
                auth('api-app')->user()?->type == UserType::PROVIDER->value &&
                $this->action == OrderAction::GO_TO_LOCATION->value &&
                $this->status == OrderStatus::IN_PROGRESS->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canFinishService(): Attribute
    {
        return Attribute::get(fn() => ($this->provider_id == auth('api-app')->id() ||
                $this->customer_id == auth('api-app')->id()) &&
            $this->action == OrderAction::START_SERVICE->value &&
            $this->status == OrderStatus::IN_PROGRESS->value
            && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canOfferPrice(): Attribute
    {
        return Attribute::get(
            fn() => $this->provider_id == auth('api-app')->id() &&
                auth('api-app')->user()?->type == UserType::PROVIDER->value &&
                auth('api-app')->user()?->canOfferOnOrder == true &&
                $this->price == null &&
                $this->status == OrderStatus::AWAITING->value &&
                $this->negotiate_status == OrderNegotiateStatus::UN_PRICED->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canAcceptOrder(): Attribute
    {
        return Attribute::get(
            fn() => $this->customer_id == auth('api-app')->id() &&
                auth('api-app')->user()?->type == UserType::CUSTOMER->value &&
                $this->price != null &&
                $this->status == OrderStatus::AWAITING->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canCanselOrder(): Attribute
    {
        return Attribute::get(
            fn() => $this->status != OrderStatus::CANCELED->value
                && $this->status == OrderStatus::AWAITING->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canRequestDiscount(): Attribute
    {
        return Attribute::get(
            fn() => $this->customer_id == auth('api-app')->id() &&
                auth('api-app')->user()?->type == UserType::CUSTOMER->value &&
                $this->price != null &&
                $this->status == OrderStatus::AWAITING->value &&
                $this->has_discount_before == 0 &&
                $this->negotiate_status == OrderNegotiateStatus::PRICED->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canDiscount(): Attribute
    {
        return Attribute::get(
            fn() => $this->provider_id == auth('api-app')->id() &&
                auth('api-app')->user()?->type == UserType::PROVIDER->value &&
                auth('api-app')->user()?->canOfferOnOrder == true &&
                $this->price != null &&
                $this->status == OrderStatus::AWAITING->value &&
                $this->has_discount_before == 0 &&
                $this->negotiate_status == OrderNegotiateStatus::NEED_CHANGE->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function canFixThePrice(): Attribute
    {
        return Attribute::get(
            fn() => $this->provider_id == auth('api-app')->id() &&
                auth('api-app')->user()?->type == UserType::PROVIDER->value &&
                auth('api-app')->user()?->canOfferOnOrder == true &&
                $this->price != null &&
                $this->status == OrderStatus::AWAITING->value &&
                $this->negotiate_status == OrderNegotiateStatus::NEED_CHANGE->value
                && $this->is_stopped == self::NOT_STOPPED

        );
    }

    public function offerExist(): Attribute
    {
        return Attribute::get(
            fn() => $this->offers()?->where('provider_id', auth('api-app')->id())->exists()
        );
    }

    public function priceTitle(): Attribute
    {
        return Attribute::make(get: function () {
            if (!is_null($this->unit_id))
                return $this->price . __('general.LE') . ' / ' . $this->unit?->t('name');
            return $this->price . __('general.LE');
        });
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function questionRate()
    {
        return $this->hasMany(QuestionRate::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function myOffers()
    {
        return $this->offers()?->where('provider_id', auth('api-app')->id());
    }

    public function chatRoom()
    {
        return $this->hasOne(ChatRoom::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(ChatRoomMessage::class, ChatRoom::class);
    }

    public function images()
    {
        return $this->hasMany(OrderImage::class);
    }
}
