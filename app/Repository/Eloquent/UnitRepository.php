<?php

namespace App\Repository\Eloquent;

use App\Models\Unit;
use App\Repository\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UnitRepository extends Repository implements UnitRepositoryInterface
{
    protected Model $model;

    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }

}
