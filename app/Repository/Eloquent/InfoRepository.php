<?php

namespace App\Repository\Eloquent;

use App\Models\Info;
use App\Repository\InfoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class InfoRepository extends Repository implements InfoRepositoryInterface
{
    protected Model $model;

    public function __construct(Info $model)
    {
        parent::__construct($model);
    }

    public function getText()
    {
        return $this->model::query()->where('type','text')->get(['id', 'key', 'value', 'name_ar', 'name_en','type']);
    }

    public function getImages()
    {
        return $this->model::query()->where('type','image')->get(['id', 'key', 'value', 'name_ar', 'name_en','type']);
    }

    public function updateValues($key, $value)
    {
        return $this->model::query()->where('key', $key)->update(['value' => $value]);
    }

    public function pointDiscount()
    {
        return $this->model::query()->where('key', 'point_discount')->first()?->value;
    }

    public function pointPrice()
    {
        return $this->model::query()->where('key', 'point_price')->first()?->value;
    }
}
