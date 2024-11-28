<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $table = 'offers';
    protected $guarded = [];

    public function priceTitle():Attribute{
        return Attribute::make(get: function (){
            if(!is_null($this->unit_id))
                return $this->price . __('general.LE') .' / '. $this->unit?->t('name');
            return $this->price . __('general.LE');
        });
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class,'provider_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }
}
