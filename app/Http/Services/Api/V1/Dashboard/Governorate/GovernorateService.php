<?php

namespace App\Http\Services\Api\V1\Dashboard\Governorate;

use App\Http\Requests\Api\V1\Dashboard\Governorate\GovernorateRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\GovernorateRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Governorate\GovernorateResource;
use App\Http\Resources\V1\Dashboard\Governorate\GovernorateCollection;
use App\Http\Resources\V1\Dashboard\Governorate\OneGovernorateResource;

class GovernorateService
{
    use Responser;

    public function __construct(
        private readonly GovernorateRepositoryInterface $governorateRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(GovernorateCollection::class, $this->governorateRepository,method: 'getAllGovernorates',is_instance: true);
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
            $governorate = $this->governorateRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new GovernorateResource($governorate));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneGovernorateResource::class, $this->governorateRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update($request, $id)
    {
        try
        {
            $governorate = $this->governorateRepository->getById($id);
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $data['sort_ar'] = mb_substr(trim($request->name_ar), 0, 1);
            $data['sort_en'] = mb_substr(trim($request->name_en), 0, 1);
            $this->governorateRepository->update($id, $data);
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
            $this->governorateRepository->delete($id);
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
            $governorate = $this->governorateRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->governorateRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
