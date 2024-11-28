<?php

namespace App\Models;

use App\Http\Enums\ChangeTypeEnum;
use App\Http\Enums\OrderStatus;
use App\Http\Enums\UserType;
use App\Repository\InfoRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function token()
    {
        return JWTAuth::fromUser($this);
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return null;
            }
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn() => $this->image !== null ? url($this->image) : null);
    }

    protected function canOfferOnOrder(): Attribute
    {
        return Attribute::make(get: fn() => $this->wallet >= app(InfoRepositoryInterface::class)->pointDiscount());
    }

//    public function getNationalIdImageAttribute($value)
//    {
//        return Attribute::get(fn() => $this->national_id_image !== null ? url($this->national_id_image) : null);
//    }

    // public function national_id_image(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             if ($value !== null) {
    //                 return url($value);
    //             }
    //             return null;
    //         }
    //     );
    // }

    protected function nationalIdImage(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return null;
            }
        );
    }

//    public function getCriminalRecordSheetAttribute($value)
//    {
//        return Attribute::get(fn() => $this->criminal_record_sheet !== null ? url($this->criminal_record_sheet) : null);
//    }

    // public function criminal_record_sheet(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             if ($value !== null) {
    //                 return url($value);
    //             }
    //             return null;
    //         }
    //     );
    // }

    protected function criminalRecordSheet(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return null;
            }
        );
    }

    public function isVerified(): Attribute
    {
        return Attribute::make(get: fn() => !$this->otp()?->exists());
    }

    public function otpToken(): Attribute
    {
        return Attribute::make(get: fn() => $this->otp?->token);
    }

    public function averageRate(): Attribute
    {
        return Attribute::make(get: function () {
            return round($this->rates()?->avg('rate')) ?? 0;
        });
    }

    public function mainDataChanges()
    {
        return $this->hasOne(Change::class)->where('type',ChangeTypeEnum::MAIN_DETAILS->value);
    }
    public function serviceImagesChanges()
    {
        return $this->hasOne(Change::class)->where('type',ChangeTypeEnum::SERVICE_IMAGES->value);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function getLastThreeComments()
    {
        return $this->hasMany(Comment::class)->latest()->take(3);
    }

    public function fixedServices()
    {
        return $this->hasMany(UserFixedService::class);
    }

    public function serviceImages()
    {
        return $this->hasMany(UserServiceImage::class);
    }

    public function fromcomplaints()
    {
        return $this->hasMany(Complaint::class, 'from');
    }

    public function tocomplaints()
    {
        return $this->hasMany(Complaint::class, 'to');
    }


    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsToMany(SubCategory::class)->limit(1);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'city_user');
    }

    public function citiesGroup()
    {
        return $this->cities->groupBy('id');
    }

    public function workTime()
    {
        return $this->hasMany(UserTime::class);
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }

    public function myOrders()
    {
        return auth('api-app')->user()->type == UserType::PROVIDER->value ?
            $this->ordersAsProvider()->where('status', OrderStatus::AWAITING->value) :
            $this->ordersAsCustomer()->where('status', OrderStatus::AWAITING->value);
    }

    public function myOffers()
    {
        $date = Carbon::now()->subMonth();
        return auth('api-app')->user()->type == UserType::PROVIDER->value ?
            $this->offersAsProvider()->where('created_at', '>=', $date) :
            $this->offersAsCustomer()->where('created_at', '>=', $date);
    }

    public function ordersAsCustomer()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function ordersAsCustomerFinished()
    {
        return $this->hasMany(Order::class, 'customer_id')->where('status', 'finished')->count();
    }

    public function ordersAsProvider()
    {
        return $this->hasMany(Order::class, 'provider_id');
    }

    public function lastOrder()
    {
        return $this->hasMany(Order::class, 'provider_id')->latest()->first();
    }

    public function ordersAsProviderFinished()
    {
        return $this->hasMany(Order::class, 'provider_id')->where('status', 'finished')->count();
    }

    public function providerNewOrders()
    {
        return $this->hasMany(Order::class, 'provider_id')
            ->where('status', 'awaiting')->latest()->take(5);
    }

    public function offersAsCustomer()
    {
        return $this->hasMany(Offer::class, 'customer_id');
    }

    public function offersAsProvider()
    {
        return $this->hasMany(Offer::class, 'provider_id');
    }

    public function walletTransaction()
    {
        return $this->hasMany(WalletTransaction::class, 'user_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function ordersAsProviderCounter()
    {
        return $this->ordersAsProvider->count();
    }

    public function ordersAsCustomerCounter()
    {
        return $this->ordersAsCustomer->count();
    }

    public function questionRateProviders()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    public function questionRateCustomer()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function questionRateProviderCount()
    {
        return $this->questionRateProviders->count();
    }

    public function chatRooms()
    {
        return $this->hasMany(ChatRoomMember::class, 'user_id');
    }

    public function chatRoomMessage()
    {
        return $this->hasMany(ChatRoomMessage::class, 'user_id');
    }

//    public function avarageRate(): Attribute
//    {
//        return Attribute::get(
//            get: function () {
//                $user = $this->where('is_active', true)->first();
//                $sum = 0;
//                foreach ($user->questionRateProviders as $item) {
//                    $sum += $item->rate;
//                }
//                if ($user->questionRateProviderCount() > 0) {
//                    $user->avarage = round($user->avarage = $sum / $user->questionRateProviderCount(), 1);
//                } else {
//                    $user->avarage = round($user->avarage = $sum / 1, 1);
//                }
//                return $user->avarage;
//            }
//        );
//    }

    public function otp()
    {
        return $this->hasOne(Otp::class);
    }

    public function providerReviews()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    public function customerReviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function rates()
    {
        return $this->hasManyThrough(ReviewRates::class, Review::class, 'provider_id');
    }

    public function contactus()
    {
        return $this->hasMany(ContactUs::class);
    }


    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }
}
