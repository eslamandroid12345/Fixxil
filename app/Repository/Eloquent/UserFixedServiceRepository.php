<?php

namespace App\Repository\Eloquent;

use App\Models\UserFixedService;
use App\Repository\UserFixedServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserFixedServiceRepository extends Repository implements UserFixedServiceRepositoryInterface
{
    protected Model $model;

    public function __construct(UserFixedService $model)
    {
        parent::__construct($model);
    }

}
