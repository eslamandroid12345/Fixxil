<?php

namespace App\Repository\Eloquent;

use App\Models\Change;
use App\Repository\ChangeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ChangeRepository extends Repository implements ChangeRepositoryInterface
{
    public function __construct(Change $model)
    {
        parent::__construct($model);
    }

    public function paginateChangesDashboard()
    {
        return $this->model::query()
            ->select(['id', 'type', 'user_id'])
            ->with('user:id,name')
            ->when(request()->has('search') && request('search') != null, function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id', 'like', $searchTerm)
                        ->orWhereHas('user', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', $searchTerm);
                        });
                });
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            ->latest()
            ->paginate(request('perPage'));
    }

}
