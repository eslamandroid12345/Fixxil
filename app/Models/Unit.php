<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory,LanguageToggle;
    protected $table = 'units';

    protected $guarded = [];

    public function fixedService()
    {
        return $this->hasMany(UserFixedService::class);
    }
}
