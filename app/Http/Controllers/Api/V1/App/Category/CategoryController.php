<?php

namespace App\Http\Controllers\Api\V1\App\Category;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Category\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $category,
    )
    {
    }

    public function categoriesHome()
    {
        return $this->category->categoriesHome();
    }

    public function index()
    {
        return $this->category->index();
    }
    public function getMainCategoryFromSub($id)
    {
        return $this->category->getMainCategoryFromSub($id);
    }

    public function getAllSubCategory()
    {
        return $this->category->getAllSubCategory();
    }

    public function getAllSubCategoryForCategory($id)
    {
        return $this->category->getAllSubCategoryForCategory($id);
    }

}
