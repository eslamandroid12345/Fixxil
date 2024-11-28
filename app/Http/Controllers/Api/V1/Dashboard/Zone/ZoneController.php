<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Zone;
use App\Http\Requests\Api\V1\Dashboard\Zone\ZoneRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\Zone\ZoneService;

class ZoneController extends Controller
{
    public function __construct(private readonly ZoneService $zone)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:zone-read')->only('index' , 'show');
        $this->middleware('permission:zone-create')->only('store');
        $this->middleware('permission:zone-update')->only('update','changeStatus');
        $this->middleware('permission:zone-delete')->only('destroy');
    }

    public function index()
    {
        return $this->zone->index();
    }

    public function show($id)
    {
        return $this->zone->show($id);
    }

    public function store(ZoneRequest $request)
    {
        return $this->zone->store($request);
    }

    public function update(ZoneRequest $request, $id)
    {
        return $this->zone->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->zone->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->zone->changeStatus($request,$id);
    }

    public function getAllZonesForCity($id)
    {
        return $this->zone->getAllZonesForCity($id);
    }
}
