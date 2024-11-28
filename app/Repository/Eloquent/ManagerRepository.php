<?php

namespace App\Repository\Eloquent;

use App\Models\Manager;
use App\Repository\ManagerRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ManagerRepository extends Repository implements ManagerRepositoryInterface
{
    protected Model $model;

    public function __construct(Manager $model)
    {
        parent::__construct($model);
    }

    public function getCount()
    {
        return $this->model::query()->where('id', '!=', auth()->id())->count();
    }
}
