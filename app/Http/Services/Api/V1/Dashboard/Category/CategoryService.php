<?php

namespace App\Http\Services\Api\V1\Dashboard\Category;

use App\Http\Requests\Api\V1\Dashboard\Category\CategoryRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\SubCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Category\CategoryResource;
use App\Http\Resources\V1\Dashboard\Category\CategoryCollection;
use App\Http\Resources\V1\Dashboard\Category\OneCategoryResource;

class CategoryService
{
    use Responser;

    public function __construct(
        private readonly CategoryRepositoryInterface    $categoryRepository,
        private readonly SubCategoryRepositoryInterface $subcategoryRepository,
        private readonly GetService                     $getService,
        private readonly FileManagerService             $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(CategoryCollection::class, $this->categoryRepository, method: 'getAllCategoryDashboard', is_instance: true);
    }

    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image'] = $this->fileManagerService->handle("image", "category/images");
            }
            $data['is_active'] = $request->is_active ? true : false;
            $data['show_home'] = $request->show_home ? true : false;
            $category = $this->categoryRepository->create($data);
            if ($request->is_subcategory) {
                $this->subcategoryRepository->create([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'category_id' => $category->id,
                    'is_active' => true,
                ]);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new CategoryResource($category));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneCategoryResource::class, $this->categoryRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryRepository->getById($id);
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image'] = $this->fileManagerService->handle("image", "brands/images", $category->getRawOriginal('image'));
            }
            $data['is_active'] = $request->is_active ? true : false;
            $data['show_home'] = $request->show_home ? true : false;
            $this->categoryRepository->update($id, $data);
//            if ($request->is_subcategory != true) {
//                $subcategory = $this->subcategoryRepository->first('category_id', $category->id);
//                if ($subcategory)
//                    $this->subcategoryRepository->delete($subcategory->id);
//            }
            $this->categoryRepository->update($id, ['updated_at' => now()]);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($request, $id)
    {
        try {
            $category = $this->categoryRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->categoryRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
