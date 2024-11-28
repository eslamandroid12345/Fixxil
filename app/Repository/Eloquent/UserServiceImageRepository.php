<?php

namespace App\Repository\Eloquent;

use App\Models\UserServiceImage;
use App\Repository\UserServiceImageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserServiceImageRepository extends Repository implements UserServiceImageRepositoryInterface
{
    protected Model $model;

    public function __construct(UserServiceImage $model)
    {
        parent::__construct($model);
    }

}
