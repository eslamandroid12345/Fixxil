<?php

namespace App\Repository\Eloquent;

use App\Models\City;
use App\Repository\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CityRepository extends Repository implements CityRepositoryInterface
{
    protected Model $model;

    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function getAllCitiesForGoverment($id)
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()->where('is_active',1)->where('governorate_id',$id)->orderBy($orderByColumn, 'asc')->get();
    }

    public function getAllCitiesForGovermentDashbord($id)
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()->where('governorate_id',$id)
        ->when(request()->filled('search'), function ($query) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', '%' . $search . '%')
                    ->orWhere('name_ar', 'like', '%' . $search . '%');
            });
        })
        ->orderBy($orderByColumn,'asc')->paginate(request('perPage'));
    }

    public function getAllCitiesForSearch()
    {
        return $this->model::query()
            ->where('is_active',true)
            ->when(request()->filled('search'), function ($query) {
                $search = request('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name_en', 'like', '%' . $search . '%')
                        ->orWhere('name_ar', 'like', '%' . $search . '%');
                });
            })
            ->when(request()->has('governorate_id') && request('governorate_id') != null, function ($q) {
                $q->where('governorate_id', request('governorate_id'));
            })
            ->get();
    }

    public function getAllCities()
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
            ->orderBy($orderByColumn,'asc')
            ->paginate(request('perPage'));
    }

    public function getActiveCities()
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()->where('is_active', 1)->orderBy($orderByColumn, 'asc')->get();
    }

}
