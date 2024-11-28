<?php

namespace App\Http\Services\Api\V1\App\Category;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\SubCategoryRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Category\CategoryResource;
use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;

abstract class CategoryService extends PlatformService
{
    use Responser;

    public function __construct(
        protected readonly CategoryRepositoryInterface    $categoryRepository,
        protected readonly SubCategoryRepositoryInterface $subCategoryRepository,
        private readonly GetService                     $getService,
    )
    {
    }

    public function categoriesHome()
    {
        return $this->getService->handle(CategoryResource::class, $this->categoryRepository, 'getAllCategoryHome');
    }

    public function index()
    {
        return $this->getService->handle(CategoryResource::class, $this->categoryRepository, 'getAllCategory');
    }

    public function getAllSubCategory()
    {
        return $this->getService->handle(SubCategoryResource::class, $this->subCategoryRepository, 'getActive');
    }

    public function getAllSubCategoryForCategory($id)
    {
        return $this->getService->handle(SubCategoryResource::class, $this->subCategoryRepository, 'getByCategoryId', parameters: [$id]);
    }

    public function getMainCategoryFromSub($id)
    {

        $mainCategory = $this->subCategoryRepository->getById($id, relations: ['category.subCategories'])->category;
        return $this->responseSuccess(data: [
            'category_name' => $mainCategory->t('name') ,
            'sub_categories' => SubCategoryResource::collection($mainCategory->subCategories) ,
        ]);
    }
}
