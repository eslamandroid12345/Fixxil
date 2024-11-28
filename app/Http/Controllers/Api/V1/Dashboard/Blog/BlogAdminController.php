<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Blog\BlogRequest;
use App\Http\Requests\Api\V1\Dashboard\Blog\BlogImageRequest;
use App\Http\Services\Api\V1\Dashboard\Blog\BlogAdminService;
use Illuminate\Http\Request;

class BlogAdminController extends Controller
{
    public function __construct(private readonly BlogAdminService $blog)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:blog-admin-read')->only('index');
        $this->middleware('permission:blog-admin-show')->only('show');
        $this->middleware('permission:blog-admin-create')->only('store');
        $this->middleware('permission:blog-admin-update')->only( 'update','changeStatus');
        $this->middleware('permission:blog-admin-delete')->only('destroy');
    }

    public function index()
    {
        return $this->blog->index();
    }

    public function store(BlogRequest $request)
    {
        return $this->blog->store($request);
    }

    public function show($id)
    {
        return $this->blog->show($id);
    }

    public function update(BlogRequest $request,$id)
    {
        return $this->blog->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->blog->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->blog->changeStatus($request,$id);
    }

    public function deleteComment($id)
    {
        return $this->blog->deleteComment($id);
    }

    public function getCommentForBlog($id)
    {
        return $this->blog->getCommentForBlog($id);
    }

    public function deleteImage($id)
    {
        return $this->blog->deleteImage($id);
    }

    public function storeImages(BlogImageRequest $request,$id)
    {
        return $this->blog->storeImages($request,$id);
    }
}
