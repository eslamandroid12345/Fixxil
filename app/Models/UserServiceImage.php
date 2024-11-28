<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServiceImage extends Model
{
    use HasFactory;
    protected $table = 'user_service_images';
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
