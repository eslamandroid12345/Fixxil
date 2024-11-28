<?php

namespace App\Http\Services\Api\V1\Dashboard\UseCategory;

use App\Http\Requests\Api\V1\Dashboard\UseCategory\UseCategoryRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\UseCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\UseCategory\UseCategoryResource;
use App\Http\Resources\V1\Dashboard\UseCategory\UseCategoryCollection;
use App\Http\Resources\V1\Dashboard\UseCategory\OneUseCategoryResource;

class UseCategoryService
{
    use Responser;

    public function __construct(
        private readonly UseCategoryRepositoryInterface $useCategoryRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(UseCategoryCollection::class, $this->useCategoryRepository,method:'getAllUsesCategoriesDashboard',is_instance: true);
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $useCategory = $this->useCategoryRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new OneUseCategoryResource($useCategory));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneUseCategoryResource::class, $this->useCategoryRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update($request, $id)
    {
        try
        {
            $useCategory = $this->useCategoryRepository->getById($id);
            $data = $request->validated();
            $this->useCategoryRepository->update($id, $data);
            $this->useCategoryRepository->update($id, ['updated_at' => now()]);
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
            $this->useCategoryRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
