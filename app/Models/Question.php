<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory,LanguageToggle;

    protected $table = 'questions';
    protected $guarded = [];

    public function questionRate()
    {
        return $this->hasMany(QuestionRate::class);
    }

}
