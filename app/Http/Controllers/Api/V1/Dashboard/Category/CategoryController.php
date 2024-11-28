<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Category\CategoryRequest;
use App\Http\Services\Api\V1\Dashboard\Category\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $category)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:category-read')->only('index' , 'show');
        $this->middleware('permission:category-create')->only( 'store');
        $this->middleware('permission:category-update')->only( 'update');
        $this->middleware('permission:category-delete')->only('destroy');
    }

    public function index()
    {
        return $this->category->index();
    }

    public function show($id)
    {
        return $this->category->show($id);
    }

    public function store(CategoryRequest $request)
    {
        return $this->category->store($request);
    }

    public function update(CategoryRequest $request, $id)
    {
        return $this->category->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->category->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->category->changeStatus($request,$id);
    }
}
