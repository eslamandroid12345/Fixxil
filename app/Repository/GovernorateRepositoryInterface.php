<?php

namespace App\Repository;

interface GovernorateRepositoryInterface extends RepositoryInterface
{
    public function getAllGovernorates();
    public function getActiveGovernorate();
}
