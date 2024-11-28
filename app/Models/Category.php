<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, LanguageToggle;

    protected $table = 'categories';
    protected $guarded = [];

    public function image() : Attribute {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return null;
            }
        );
    }
    public function choosed(): Attribute
    {
        return Attribute::make(get: function (){
            return $this->subCategories()->whereHas('users', function ($query) {
                $query->where('users.id', auth('api-app')->id());
            })->exists();
        });
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function activeSubCategories()
    {
        return $this->subCategories()->where('is_active', true);
    }
}
