<?php

namespace App\Repository\Eloquent;

use App\Models\UserPackage;
use App\Repository\UserPackageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserPackageRepository extends Repository implements UserPackageRepositoryInterface
{
    protected Model $model;

    public function __construct(UserPackage $model)
    {
        parent::__construct($model);
    }


}
