<?php

namespace App\Repository;

interface CityRepositoryInterface extends RepositoryInterface
{
    public function getAllCitiesForGoverment($id);
    public function getAllCitiesForSearch();

    public function getAllCitiesForGovermentDashbord($id);

    public function getAllCities();
    public function getActiveCities();
}
