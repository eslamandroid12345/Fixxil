<?php

namespace App\Repository\Eloquent;

use App\Models\Blog;
use App\Repository\BlogRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlogRepository extends Repository implements BlogRepositoryInterface
{
    protected Model $model;

    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function getAllBlogs($is_published = false)
    {
        $query = $this->model::query()
            ->where('is_blog', true)
            // ->where('is_published', true)
            ->when(request()->has('category_id') && request('category_id') != null, function ($query) {
                $query->where('category_id', request('category_id'));
            });
        if ($is_published)
            $query->where('is_published', true);

        $query->when(request()->has('search') && request('search') != null, function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        })
            ->when(request()->has('is_published') && request('is_published') != null, function ($q) {
                $q->where('is_published', request('is_published'));
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            ->when(request()->has('my_blog') && request('my_blog') != null, function ($q) {
                $q->where('user_id', auth('api-app')->id());
            });
        $query->withMax('comments', 'created_at')
            ->orderByRaw('GREATEST(blogs.created_at, IFNULL(comments_max_created_at, blogs.created_at)) DESC');

        return $query->paginate(request('perPage'));
    }


    public function getAllBlogsAdmin($is_published = false)
    {
        $query = $this->model::query()
            ->where('is_blog', true)
            ->where('manager_id', '!=', null)
            ->when(request()->has('category_id') && request('category_id') != null, function ($query) {
                $query->where('category_id', request('category_id'));
            });
        $query->orderByDesc(
            DB::table('comments')
                ->select('created_at')
                ->whereColumn('comments.blog_id', 'blogs.id')
                ->orderBy('created_at', 'desc')
                ->limit(1)
        )
            ->when(request()->has('search') && request('search') != null, function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%');
            })
            ->when(request()->has('search') && request('search') != null, function ($query) {
                $query->where('content', 'like', '%' . request('search') . '%');
            })
            ->when(request()->has('is_published') && request('is_published') != null, function ($q) {
                $q->where('is_published', request('is_published'));
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->where('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->where('created_at', '<=', request('date_to'));
            })
            ->orderBy('created_at', 'desc');
        return $query->paginate(request('perPage'));
    }

    public function getAllQuestions()
    {
        $query = $this->model::query()
            ->where('is_blog', false)
            ->where('is_published', true)
            ->when(request()->has('category_id') && request('category_id') != null, function ($query) {
                $query->where('category_id', request('category_id'));
            })
            ->when(request()->has('my_blog') && request('my_blog') == 1, function ($q) {
                $q->where('user_id', auth('api-app')->id());
            });

        $query->withMax('comments', 'created_at')
            ->orderByRaw('GREATEST(blogs.created_at, IFNULL(comments_max_created_at, blogs.created_at)) DESC');

        return $query->paginate(10);
    }

    public function getAllQuestionsDashboard()
    {
        $query = $this->model::query()
            ->where('is_blog', false)
//            ->where('is_published', true)
            ->when(request()->has('category_id') && request('category_id') != null, function ($query) {
                $query->where('category_id', request('category_id'));
            })
            ->when(request()->has('search') && request('search') != null, function ($query) {
                $query->where('content', 'like', '%' . request('search') . '%');
            })
            ->when(request()->has('is_published') && request('is_published') != null, function ($q) {
                $q->where('is_published', request('is_published'));
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            });
        $query->withMax('comments', 'created_at')
            ->orderByRaw('GREATEST(blogs.created_at, IFNULL(comments_max_created_at, blogs.created_at)) DESC');
        return $query->paginate(request('perPage'));
    }

    public function getBlogsForHome()
    {
        return $this->model::query()
            ->where('is_published', true)
            ->where('is_blog', true)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();
    }

    public function getAllBlogsCount()
    {
        $query = $this->model::query()
            ->where('is_blog', true)
            ->count();

        return $query;
    }

    public function getLastBlogs()
    {
        return $this->model::query()
            ->where('is_blog', true)
            ->with('user')
            ->latest()
            ->take(5)->get();
    }

    public function getLastQuestions()
    {
        return $this->model::query()
            ->where('is_blog', false)
            ->with('user')
            ->latest()
            ->take(5)->get();
    }

}
