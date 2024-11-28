<?php

namespace App\Http\Controllers\Api\V1\Dashboard\UseCategory;
use App\Http\Requests\Api\V1\Dashboard\UseCategory\UseCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\UseCategory\UseCategoryService;

class UseCategoryController extends Controller
{
    public function __construct(private readonly UseCategoryService $useCategory)
    {
        $this->middleware('auth:api-manager');

        $this->middleware('permission:use-category-read')->only('index');
        $this->middleware('permission:use-category-show')->only('show');
        $this->middleware('permission:use-category-create')->only('store');
        $this->middleware('permission:use-category-update')->only('update');
        $this->middleware('permission:use-category-delete')->only('destroy');
    }

    public function index()
    {
        return $this->useCategory->index();
    }

    public function show($id)
    {
        return $this->useCategory->show($id);
    }

    public function store(UseCategoryRequest $request)
    {
        return $this->useCategory->store($request);
    }

    public function update(UseCategoryRequest $request, $id)
    {
        return $this->useCategory->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->useCategory->destroy($id);
    }
}
