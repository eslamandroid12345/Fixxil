<?php

namespace App\Http\Services\Api\V1\Dashboard\SubCategory;

use App\Http\Requests\Api\V1\Dashboard\SubCategory\SubCategoryRequest;
use App\Repository\SubCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\Dashboard\SubCategory\OneSubCategoryResource;

class SubCategoryService
{
    use Responser;

    public function __construct(
        private readonly SubCategoryRepositoryInterface $subCategoryRepository,
        private readonly GetService                     $getService,
    )
    {
    }

    public function index($categoryId)
    {
        return $this->getService->handle(SubCategoryResource::class, $this->subCategoryRepository, 'getByCategoryId', [$categoryId]);
    }

    public function store(SubCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $subCategory = $this->subCategoryRepository->create($data);
            DB::commit();
            return $this->responseSuccess(Http::OK, __('messages.created successfully'), new SubCategoryResource($subCategory));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneSubCategoryResource::class, $this->subCategoryRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(SubCategoryRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $this->subCategoryRepository->update($id, $data);
            $this->subCategoryRepository->update($id, ['updated_at' => now()]);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try {
            $this->subCategoryRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($request,$id)
    {
        try
        {
            $subcategory = $this->subCategoryRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->subCategoryRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getSubCategoriesByCategory($id)
    {
        return $this->getService->handle(SubCategoryResource::class, $this->subCategoryRepository, method: 'getByCategoryId', parameters: [$id]);
    }
}
