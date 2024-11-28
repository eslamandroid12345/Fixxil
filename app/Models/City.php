<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory,LanguageToggle;
    protected $table = 'cities';

    protected $guarded = [];
    public function choosed(): Attribute
    {
        return Attribute::make(get: function (){
            if($this->users()?->where('users.id',auth('api-app')->id())->exists())
                return true;
            return false;
        });
    }

    public function zones()
    {
        return $this->hasMany(Zone::class,'city_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class,'governorate_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'city_user');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
