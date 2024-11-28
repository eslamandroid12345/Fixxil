<?php

namespace App\Repository\Eloquent;

use Spatie\Permission\Models\Role;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends Repository implements RoleRepositoryInterface
{
    protected Model $model;

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
