<?php

namespace App\Repository\Eloquent;

use App\Models\SubCategory;
use App\Repository\SubCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SubCategoryRepository extends Repository implements SubCategoryRepositoryInterface
{
    protected Model $model;

    public function __construct(SubCategory $model)
    {
        parent::__construct($model);
    }

    public function getByCategoryId($id)
    {
        return $this->model::query()->where('category_id', $id)
        ->orderBy('created_at','asc')
        ->orderBy('updated_at','desc')
        ->get();
    }

}
