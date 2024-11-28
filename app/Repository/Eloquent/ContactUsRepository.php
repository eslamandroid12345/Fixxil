<?php

namespace App\Repository\Eloquent;

use App\Models\ContactUs;
use App\Repository\ContactUsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ContactUsRepository extends Repository implements ContactUsRepositoryInterface
{
    protected Model $model;

    public function __construct(ContactUs $model)
    {
        parent::__construct($model);
    }

    public function getAllContactUs()
    {
        return $this->model::query()
            ->when(request()->has('search') && request('search') != null, function ($q) {
                $searchTerm = '%' . request('search') . '%';
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('phone', 'like', $searchTerm)
                    ->orWhere('message', 'like', $searchTerm);
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            ->latest()
            ->select(['*'])
            ->paginate(request('perPage'));
    }

}
