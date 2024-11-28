<?php

namespace App\Repository;

interface ZoneRepositoryInterface extends RepositoryInterface
{
    public function getAllZonesForCity($id);
    public function getAllZonesForCityDashboard($id);

    public function getAllZons();
    public function getActiveZones();
}
