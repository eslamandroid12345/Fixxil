<?php

namespace App\Http\Controllers\Api\V1\App\Zone;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Zone\ZoneService;

class ZoneController extends Controller
{
    public function __construct(
        private readonly ZoneService $zone,
    )
    {
    }

    public function index()
    {
        return $this->zone->index();
    }

    public function getAllZonesForCity($id)
    {
        return $this->zone->getAllZonesForCity($id);
    }
}
