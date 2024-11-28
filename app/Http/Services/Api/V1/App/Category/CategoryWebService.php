<?php

namespace App\Http\Services\Api\V1\App\Category;

use App\Http\Resources\V1\App\SubCategory\SubCategoryResource;
use App\Http\Services\Mutual\GetService;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\SubCategoryRepositoryInterface;

class CategoryWebService extends CategoryService
{


    public function __construct(CategoryRepositoryInterface $categoryRepository, SubCategoryRepositoryInterface $subCategoryRepository, GetService $getService)
    {
        parent::__construct($categoryRepository, $subCategoryRepository, $getService);
    }

    public static function platform(): string
    {
        return 'website';
    }

    public function getAllSubCategoryForCategory($id)
    {
        $mainCategory = $this->categoryRepository->getById($id);
        return [
            'category_name' => $mainCategory->t('name'),
            'sub_categories' => SubCategoryResource::collection($this->subCategoryRepository->getByCategoryId($id)),
        ];
    }

}
