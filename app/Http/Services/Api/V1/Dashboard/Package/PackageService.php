<?php

namespace App\Http\Services\Api\V1\Dashboard\Package;

use App\Http\Requests\Api\V1\Dashboard\Package\PackageRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\PackageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Package\PackageResource;
use App\Http\Resources\V1\Dashboard\Package\PackageCollection;
use App\Http\Resources\V1\Dashboard\Package\OnePackageResource;

class PackageService
{
    use Responser;

    public function __construct(
        private readonly PackageRepositoryInterface $packageRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(PackageCollection::class, $this->packageRepository,method: 'getAllPackagesDashboard',is_instance: true);
    }

    public function store(PackageRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $package = $this->packageRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new PackageResource($package));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OnePackageResource::class, $this->packageRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(PackageRequest $request, $id)
    {
        try
        {
            $package = $this->packageRepository->getById($id);
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $this->packageRepository->update($id, $data);
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
            $this->packageRepository->delete($id);
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
            $package = $this->packageRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->packageRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
