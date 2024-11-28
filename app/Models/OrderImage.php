<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    use HasFactory;
    protected $table = 'order_images';
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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
