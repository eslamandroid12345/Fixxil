<?php

namespace App\Http\Services\Api\V1\Dashboard\Unit;

use App\Http\Requests\Api\V1\Dashboard\Unit\UnitRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\UnitRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Unit\UnitResource;
use App\Http\Resources\V1\Dashboard\Unit\OneUnitResource;
use App\Http\Resources\V1\Dashboard\Unit\UnitCollection;

class UnitService
{
    use Responser;

    public function __construct(
        private readonly UnitRepositoryInterface $unitRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(UnitCollection::class, $this->unitRepository,'paginate',is_instance: true);
    }

    public function store(UnitRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $unit = $this->unitRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UnitResource($unit));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneUnitResource::class, $this->unitRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(UnitRequest $request, $id)
    {
        try
        {
            $unit = $this->unitRepository->getById($id);
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $this->unitRepository->update($unit->id, $data);
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
            $this->unitRepository->delete($id);
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
            $unit = $this->unitRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->unitRepository->update($unit->id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
