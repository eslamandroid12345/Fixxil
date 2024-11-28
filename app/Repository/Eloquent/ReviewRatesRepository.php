<?php

namespace App\Repository\Eloquent;

use App\Models\ReviewRates;
use App\Repository\ReviewRatesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ReviewRatesRepository extends Repository implements ReviewRatesRepositoryInterface
{
    public function __construct(ReviewRates $model)
    {
        parent::__construct($model);
    }
}
