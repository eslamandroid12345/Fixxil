<?php

namespace App\Http\Controllers\Api\V1\App\City;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\City\CityService;

class CityController extends Controller
{
    public function __construct(
        private readonly CityService $city,
    )
    {
    }

    public function index()
    {
        return $this->city->index();
    }

    public function getAllCitiesForGoverment($id)
    {
        return $this->city->getAllCitiesForGoverment($id);
    }

    public function getAllCitiesForSearch()
    {
        return $this->city->getAllCitiesForSearch();
    }
}
