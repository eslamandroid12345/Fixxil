<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function averageRate(): Attribute
    {
        return Attribute::make(get: function () {
            return number_format($this->rates()?->avg('rate'),2);
        });
    }

    public function rated(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->rates()->exists() && $this->comment != null;
        });
    }

    public function rates()
    {
        return $this->hasMany(ReviewRates::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
