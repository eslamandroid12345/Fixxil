<?php

namespace App\Http\Controllers\Api\V1\Dashboard\City;
use App\Http\Requests\Api\V1\Dashboard\City\CityRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\City\CityService;

class CityController extends Controller
{
    public function __construct(private readonly CityService $city)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:city-read')->only('index' , 'show');
        $this->middleware('permission:city-create')->only('store');
        $this->middleware('permission:city-update')->only('update','changeStatus');
        $this->middleware('permission:city-delete')->only('destroy');
    }

    public function index()
    {
        return $this->city->index();
    }

    public function show($id)
    {
        return $this->city->show($id);
    }

    public function store(CityRequest $request)
    {
        return $this->city->store($request);
    }

    public function update(CityRequest $request, $id)
    {
        return $this->city->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->city->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->city->changeStatus($request,$id);
    }

    public function getAllCitiesForGoverment($id)
    {
        return $this->city->getAllCitiesForGoverment($id);
    }
}
