<?php

namespace App\Repository\Eloquent;

use App\Models\Uses;
use App\Repository\UsesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UsesRepository extends Repository implements UsesRepositoryInterface
{
    protected Model $model;

    public function __construct(Uses $model)
    {
        parent::__construct($model);
    }

    public function getAllUsesForCategory($use_id)
    {
        return $this->model::query()->where('use_category_id',$use_id)
            ->when(request()->filled('search'), function ($query) {
                $search = request('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name_en', 'like', '%' . $search . '%')
                        ->orWhere('name_ar', 'like', '%' . $search . '%')
                        ->orWhere('description_ar', 'like', '%' . $search . '%')
                        ->orWhere('description_en', 'like', '%' . $search . '%');
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
            ->orderBy('created_at','desc')
            ->paginate(request('perPage'));
    }

    public function getAllQuestionForuses($use_id)
    {
        return $this->model::query()->where('parent_id',$use_id)
            ->when(request()->filled('search'), function ($query) {
                $search = request('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name_en', 'like', '%' . $search . '%')
                        ->orWhere('name_ar', 'like', '%' . $search . '%')
                        ->orWhere('description_ar', 'like', '%' . $search . '%')
                        ->orWhere('description_en', 'like', '%' . $search . '%');
                });
            })
            ->when(request()->filled('date_from'), function ($q) {
                $q->where('created_at', '>=', request('date_from'));
            })
            ->when(request()->filled('date_to'), function ($q) {
                $q->where('created_at', '<=', request('date_to'));
            })
            // ->orderBy('created_at', 'desc')
            ->orderBy('indexx', 'asc')
            ->orderBy('created_at','desc')
            ->paginate(request('perPage'));
    }

}
