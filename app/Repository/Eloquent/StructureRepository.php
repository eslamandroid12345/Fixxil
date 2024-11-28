<?php

namespace App\Repository\Eloquent;

use App\Models\Structure;
use App\Repository\StructureRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StructureRepository extends Repository implements StructureRepositoryInterface
{
    protected Model $model;

    public function __construct(Structure $model)
    {
        parent::__construct($model);
    }
    public function structure($key)
    {
        return $this->model::query()->where('key', $key)->first();
    }

    public function publish($key, $content)
    {
        return $this->model::query()->updateOrCreate(['key' => $key], ['content' => $content]);
    }
}
