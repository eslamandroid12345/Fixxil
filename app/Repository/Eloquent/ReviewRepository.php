<?php

namespace App\Repository\Eloquent;

use App\Models\Review;
use App\Repository\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ReviewRepository extends Repository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function getCustomerReviews()
    {
        return $this->model::query()
            ->where('customer_id', auth('api-app')->id())
            ->with('provider','order.subCategory')
            ->withAvg('rates','rate')
            ->get();
    }
    public function getProviderReviews($id)
    {
        return $this->model::query()
            ->where('provider_id', $id)
            ->with('order.subCategory','customer')
            ->withAvg('rates','rate')
            ->get();
    }
}
