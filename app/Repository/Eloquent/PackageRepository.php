<?php

namespace App\Repository\Eloquent;

use App\Models\Package;
use App\Repository\PackageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PackageRepository extends Repository implements PackageRepositoryInterface
{
    protected Model $model;

    public function __construct(Package $model)
    {
        parent::__construct($model);
    }

    public function getAllPackages()
    {
        return $this->model::query()->latest()->select(['*'])->get();
    }

    public function getAllPackagesDashboard()
    {
        return $this->model::query()
            ->when(request()->has('name') && request('name') != null, function ($q)  {
                $searchTerm = '%' . request('name') . '%';
                $q->where('name_ar', 'like', $searchTerm)
                    ->orWhere('name_en', 'like', $searchTerm);
            })
            ->latest()
            ->select(['*'])
            ->paginate(10);
    }

}
