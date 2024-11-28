<?php

namespace App\Repository\Eloquent;

use App\Models\BlogImage;
use App\Repository\BlogImageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BlogImageRepository extends Repository implements BlogImageRepositoryInterface
{
    protected Model $model;

    public function __construct(BlogImage $model)
    {
        parent::__construct($model);
    }

}
