<?php

namespace App\Repository\Eloquent;

use App\Models\Governorate;
use App\Repository\GovernorateRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class GovernorateRepository extends Repository implements GovernorateRepositoryInterface
{
    protected Model $model;

    public function __construct(Governorate $model)
    {
        parent::__construct($model);
    }

    public function getAllGovernorates()
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()
            ->when(request()->has('search') && request('search') != null, function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name_ar', 'like', $searchTerm)
                        ->orWhere('name_en', 'like', $searchTerm);
                });
            })
            // ->latest()
//            ->orderBy($orderByColumn, 'asc')
            ->orderBy($orderByColumn, 'asc')
            ->paginate(request('perPage'));
    }

    public function getActiveGovernorate()
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()->where('is_active', 1)->orderBy($orderByColumn, 'asc')->get();
    }

}
