<?php

namespace App\Models;

use App\Http\Enums\UserType;
use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory, LanguageToggle;

    protected $table = 'sub_categories';
    protected $guarded = [];

    public function choosed(): Attribute
    {
        return Attribute::make(get: function (){
            if($this->users()?->where('users.id',auth('api-app')->id())->exists())
                return true;
            return false;
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function providers()
    {
        return $this->belongsToMany(User::class)->where('type',UserType::PROVIDER->value);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
