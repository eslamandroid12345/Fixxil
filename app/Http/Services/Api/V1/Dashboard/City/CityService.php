<?php

namespace App\Http\Services\Api\V1\Dashboard\City;

use App\Http\Requests\Api\V1\Dashboard\City\CityRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\CityRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\City\CityResource;
use App\Http\Resources\V1\Dashboard\City\CityCollection;
use App\Http\Resources\V1\Dashboard\City\OneCityResource;

class CityService
{
    use Responser;

    public function __construct(
        private readonly CityRepositoryInterface $cityRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(CityCollection::class, $this->cityRepository,method:'getAllCities',is_instance: true);
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $data['sort_ar'] = mb_substr(trim($request->name_ar), 0, 1);
            $data['sort_en'] = mb_substr(trim($request->name_en), 0, 1);
            $city = $this->cityRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new CityResource($city));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneCityResource::class, $this->cityRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update($request, $id)
    {
        try
        {
            $city = $this->cityRepository->getById($id);
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $data['sort_ar'] = mb_substr(trim($request->name_ar), 0, 1);
            $data['sort_en'] = mb_substr(trim($request->name_en), 0, 1);
            $this->cityRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->cityRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($request,$id)
    {
        try
        {
            $city = $this->cityRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->cityRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getAllCitiesForGoverment($id)
    {
        return $this->getService->handle(CityCollection::class, $this->cityRepository, 'getAllCitiesForGovermentDashbord',parameters: [$id],is_instance: true);
    }
}
