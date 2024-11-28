<?php

namespace App\Repository\Eloquent;

use App\Models\CityUser;
use App\Repository\CityUserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CityUserRepository extends Repository implements CityUserRepositoryInterface
{
    protected Model $model;

    public function __construct(CityUser $model)
    {
        parent::__construct($model);
    }

}
