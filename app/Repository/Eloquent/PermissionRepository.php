<?php

namespace App\Repository\Eloquent;

use Spatie\Permission\Models\Permission;
use App\Repository\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository extends Repository implements PermissionRepositoryInterface
{
    protected Model $model;

    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
