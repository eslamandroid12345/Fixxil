<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCategory extends Model
{
    use HasFactory,LanguageToggle;

    protected $guarded = [];

    public function uses()
    {
        return $this->hasMany(Uses::class,'use_category_id')->orderBy('indexx', 'asc');
    }
}
