<?php

namespace App\Http\Controllers\Api\V1\App\Blog;

use App\Http\Requests\Api\V1\App\Blog\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Blog\BlogService;

class BlogController extends Controller
{
    public function __construct(
        private readonly BlogService $blog,
    )
    {
        $this->middleware('auth:api-app')->except(['getBlogsForHome','index','show','getAllBlogQuestions']);

    }

    public function store(BlogRequest $request)
    {
        return $this->blog->store($request);
    }

    public function index()
    {
        return $this->blog->index();
    }

    public function show($id)
    {
        return $this->blog->show($id);
    }

    public function getAllBlogQuestions()
    {
        return $this->blog->getAllBlogQuestions();
    }

    public function getBlogsForHome()
    {
        return $this->blog->getBlogsForHome();
    }
}
