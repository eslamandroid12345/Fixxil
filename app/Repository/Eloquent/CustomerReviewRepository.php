<?php

namespace App\Repository\Eloquent;

use App\Models\CustomerReview;
use App\Repository\CustomerReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CustomerReviewRepository extends Repository implements CustomerReviewRepositoryInterface
{
    public function __construct(CustomerReview $model)
    {
        parent::__construct($model);
    }
}
