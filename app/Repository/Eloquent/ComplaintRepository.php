<?php

namespace App\Repository\Eloquent;

use App\Models\Complaint;
use App\Repository\ComplaintRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ComplaintRepository extends Repository implements ComplaintRepositoryInterface
{
    protected Model $model;

    public function __construct(Complaint $model)
    {
        parent::__construct($model);
    }

    public function getAllComplaints()
    {
        return $this->model::query()
        ->when(request()->has('search') && request('search') != null, function ($query) {
            $search = '%' . request('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->whereHas('fromUser', function ($q) use ($search) {
                    $q->where('name', 'like', $search);
                })->orWhereHas('toUser', function ($q) use ($search) {
                    $q->where('name', 'like', $search);
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
