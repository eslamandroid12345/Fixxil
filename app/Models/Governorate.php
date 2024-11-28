<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;
    use HasFactory,LanguageToggle;
    protected $table = 'governorates';

    protected $guarded = [];
    public function choosed(): Attribute
    {
        return Attribute::make(get: function (){
            return $this->cities()->whereHas('users', function ($query) {
                $query->where('users.id', auth('api-app')->id());
            })->exists();
        });
    }
    public function cities()
    {
        return $this->hasMany(City::class,'governorate_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
