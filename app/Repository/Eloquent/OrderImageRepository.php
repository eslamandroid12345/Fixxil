<?php

namespace App\Repository\Eloquent;

use App\Models\OrderImage;
use App\Repository\OrderImageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderImageRepository extends Repository implements OrderImageRepositoryInterface
{
    protected Model $model;

    public function __construct(OrderImage $model)
    {
        parent::__construct($model);
    }
}
