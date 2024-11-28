<?php

namespace App\Repository;

interface OfferRepositoryInterface extends RepositoryInterface
{
    public function getAllOffersForProvider($id);
}
