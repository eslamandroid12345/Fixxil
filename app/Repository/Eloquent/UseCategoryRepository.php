<?php

namespace App\Repository\Eloquent;

use App\Models\UseCategory;
use App\Repository\UseCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UseCategoryRepository extends Repository implements UseCategoryRepositoryInterface
{
    protected Model $model;

    public function __construct(UseCategory $model)
    {
        parent::__construct($model);
    }

    public function getAllUsesCategoriesDashboard()
    {
        return $this->model::query()
            ->when(request()->filled('search'), function ($query) {
                $search = request('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name_en', 'like', '%' . $search . '%')
                        ->orWhere('name_ar', 'like', '%' . $search . '%');
                });
            })
            ->when(request()->filled('date_from'), function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->filled('date_to'), function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            // ->orderBy('created_at', 'desc')
            ->orderBy('indexx', 'asc')
            ->orderBy('updated_at','desc')
            ->paginate(request('perPage'));
    }
    public function getAllUseCategories()
    {
        return $this->model::query()
            ->with('uses.children')
            ->orderBy('indexx', 'asc')
            ->orderBy('updated_at','desc')
            ->get();
    }

}
