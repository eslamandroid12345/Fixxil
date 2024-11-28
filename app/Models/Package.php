<?php

namespace App\Models;
use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Repository\InfoRepositoryInterface;

class Package extends Model
{
    use HasFactory,LanguageToggle;

    protected $table = 'packages';
    protected $guarded = [];

    protected function getPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->number * app(InfoRepositoryInterface::class)->pointPrice();
            }
        );
    }

    public function usesr()
    {
        return $this->belongsToMany(User::class);
    }

}
