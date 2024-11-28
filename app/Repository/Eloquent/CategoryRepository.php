<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    protected Model $model;

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAllCategoryHome()
    {
        return $this->model::query()
            ->where('show_home',1)
            ->where('is_active',1)
            ->when(request()->has('name') && request('name') != null, function ($q) {
                $searchTerm = '%' . request('name') . '%';
                $q->where('name_ar', 'like', $searchTerm)
                    ->orWhere('name_en', 'like', $searchTerm);
            })
            // ->latest()
            ->orderBy('indexx', 'asc')
            ->orderBy('updated_at','desc')
            ->select(['*'])
            ->get();
    }

    public function getAllCategory()
    {
        return $this->model::query()
            ->whereHas('subCategories')
            ->where('is_active',1)
            ->when(request()->has('name') && request('name') != null, function ($q) {
                $searchTerm = '%' . request('name') . '%';
                $q->where('name_ar', 'like', $searchTerm)
                    ->orWhere('name_en', 'like', $searchTerm);
            })
            // ->latest()
            ->orderBy('indexx', 'asc')
            ->orderBy('updated_at','desc')
            ->select(['*'])
            ->get();
    }

    public function getAllCategoryDashboard()
    {
        return $this->model::query()
            ->when(request()->has('name') && request('name') != null, function ($q)  {
                $searchTerm = '%' . request('name') . '%';
                $q->where('name_ar', 'like', $searchTerm)
                    ->orWhere('name_en', 'like', $searchTerm);
            })
            // ->latest()
            ->orderBy('indexx', 'asc')
            ->orderBy('updated_at','desc')
            ->select(['*'])
            ->paginate(10);
    }

    public function getCategoriesForHome()
    {
        return $this->model::query()
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();
    }

    public function getAllMainCateogries(){
        return $this->model::query()
            ->whereHas('subCategories')
            ->with('subCategories')
            ->get();
    }


}
