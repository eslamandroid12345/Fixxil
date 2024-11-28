<?php

namespace App\Repository\Eloquent;

use App\Models\SubCategoryUser;
use App\Repository\SubCategoryUserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SubCategoryUserRepository extends Repository implements SubCategoryUserRepositoryInterface
{
    protected Model $model;

    public function __construct(SubCategoryUser $model)
    {
        parent::__construct($model);
    }

}
