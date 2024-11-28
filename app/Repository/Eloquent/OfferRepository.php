<?php

namespace App\Repository\Eloquent;

use App\Models\Offer;
use App\Repository\OfferRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OfferRepository extends Repository implements OfferRepositoryInterface
{
    protected Model $model;

    public function __construct(Offer $model)
    {
        parent::__construct($model);
    }

    public function getAllOffersForProvider($id)
    {
        return $this->model::query()->where('provider_id', $id)->where('status', 'in_progress')->latest()->get();
    }

}
