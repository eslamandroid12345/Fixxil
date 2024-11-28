<?php

namespace App\Http\Controllers\Api\V1\Dashboard\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\SubCategory\SubCategoryRequest;
use App\Http\Services\Api\V1\Dashboard\SubCategory\SubCategoryService;

class SubCategoryController extends Controller
{
    public function __construct(private readonly SubCategoryService $subCategory)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:sub-category-read')->only('index' , 'show');
        $this->middleware('permission:sub-category-create')->only('create', 'store');
        $this->middleware('permission:sub-category-update')->only('edit' , 'update');
        $this->middleware('permission:sub-category-delete')->only('destroy');
    }

    public function index($categoryId)
    {
        return $this->subCategory->index($categoryId);
    }

    public function show($id)
    {
        return $this->subCategory->show($id);
    }

    public function store(SubCategoryRequest $request)
    {
        return $this->subCategory->store($request);
    }

    public function update(SubCategoryRequest $request, $id)
    {
        return $this->subCategory->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->subCategory->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->subCategory->changeStatus($request,$id);
    }

    public function getSubCategoriesByCategory($id)
    {
        return $this->subCategory->getSubCategoriesByCategory($id);
    }
}
