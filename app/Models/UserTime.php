<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTime extends Model
{
    use HasFactory, LanguageToggle;

    protected $table = 'user_times';
    protected $guarded = [];

    public function getToAttribute($value)
    {
        if ($value === null)
            return __('messages.not_exist');
        return $value;
    }

    public function getFromAttribute($value)
    {
        if ($value === null)
            return __('messages.not_exist');
        return $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
