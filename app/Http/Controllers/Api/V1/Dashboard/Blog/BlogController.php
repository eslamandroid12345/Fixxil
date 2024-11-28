<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Blog;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Blog\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(private readonly BlogService $blog)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:blog-read')->only('index');
        $this->middleware('permission:blog-show')->only('show');
        $this->middleware('permission:blog-update')->only('changeStatus');
        $this->middleware('permission:blog-delete')->only('destroy');

        $this->middleware('permission:comment-read')->only('getAllComments');
        $this->middleware('permission:comment-delete')->only('deleteComment');
    }

    public function index()
    {
        return $this->blog->index();
    }

    public function show($id)
    {
        return $this->blog->show($id);
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
    public function getAllComments()
    {
        return $this->blog->getAllComments();
    }
}
