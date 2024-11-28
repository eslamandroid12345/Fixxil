<?php

namespace App\Http\Services\Api\V1\Dashboard\Zone;

use App\Http\Requests\Api\V1\Dashboard\Zone\ZoneRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\ZoneRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Zone\ZoneResource;
use App\Http\Resources\V1\Dashboard\Zone\ZoneCollection;
use App\Http\Resources\V1\Dashboard\Zone\OneZoneResource;

class ZoneService
{
    use Responser;

    public function __construct(
        private readonly ZoneRepositoryInterface $zoneRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(ZoneCollection::class, $this->zoneRepository,method: 'getAllZons',is_instance: true);
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
            $zone = $this->zoneRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new ZoneResource($zone));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneZoneResource::class, $this->zoneRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update($request, $id)
    {
        try
        {
            $zone = $this->zoneRepository->getById($id);
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $data['sort_ar'] = mb_substr(trim($request->name_ar), 0, 1);
            $data['sort_en'] = mb_substr(trim($request->name_en), 0, 1);
            $this->zoneRepository->update($id, $data);
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
            $this->zoneRepository->delete($id);
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
            $zone = $this->zoneRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->zoneRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getAllZonesForCity($id)
    {
        return $this->getService->handle(ZoneCollection::class, $this->zoneRepository, 'getAllZonesForCityDashboard',parameters: [$id],is_instance: true);
    }
}
