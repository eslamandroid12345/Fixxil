<?php

namespace App\Repository\Eloquent;

use App\Models\Comment;
use App\Repository\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    protected Model $model;

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function paginateCommentsDashboard()
    {
        return $this->model::query()
            ->when(request()->has('search') && request('search') != null, function ($q) {
                $searchTerm = '%' . request('search') . '%';
                $q->where('comment', 'like', $searchTerm);
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            ->latest()
            ->with('blog')
            ->select(['*'])
            ->paginate(request('perPage'));
    }
}
