<?php

namespace App\Repository\Eloquent;

use App\Models\UserTime;
use App\Repository\UserTimeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserTimeRepository extends Repository implements UserTimeRepositoryInterface
{
    protected Model $model;

    public function __construct(UserTime $model)
    {
        parent::__construct($model);
    }

    public function getTimeForUser($id, $day)
    {
        return $this->model::query()->where('user_id', $id)->where('day_en', $day)->first();
    }

    public function getFromToForDay($provider_id, $day)
    {
        return $this->model::query()
            ->where('day_index', $day)
            ->where('user_id', $provider_id)
            ->first();
    }

}
