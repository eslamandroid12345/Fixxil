<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uses extends Model
{
    use HasFactory, LanguageToggle;

    protected $table = 'uses';
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Uses::class, 'parent_id')->orderBy('indexx','asc');
    }
}
