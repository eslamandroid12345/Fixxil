<?php

namespace App\Repository\Eloquent;

use App\Models\Zone;
use App\Repository\ZoneRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ZoneRepository extends Repository implements ZoneRepositoryInterface
{
    protected Model $model;

    public function __construct(Zone $model)
    {
        parent::__construct($model);
    }

    public function getAllZonesForCity($id)
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()->where('is_active', 1)->where('city_id',$id)->orderBy($orderByColumn, 'asc')->get();
    }

    public function getAllZonesForCityDashboard($id)
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()->where('city_id',$id)
        ->when(request()->filled('search'), function ($query) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', '%' . $search . '%')
                    ->orWhere('name_ar', 'like', '%' . $search . '%');
            });
        })
        ->orderBy($orderByColumn,'asc')->paginate(request('perPage'));
    }

    public function getAllZons()
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

    public function getActiveZones()
    {
        $locale = app()->getLocale();  // Get the current locale
        $orderByColumn = $locale === 'en' ? 'name_en' : 'name_ar';  // Set the column based on the locale
        $orderByColumn1 = $locale === 'en' ? 'sort_en' : 'sort_ar';  // Set the column based on the locale

        return $this->model::query()->where('is_active', 1)->orderBy($orderByColumn, 'asc')->get();
    }
}
