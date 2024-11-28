<?php

namespace App\Http\Controllers\Api\V1\Dashboard\BlogQuestion;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\BlogQuestion\BlogQuestionService;
use Illuminate\Http\Request;

class BlogQuestionController extends Controller
{
    public function __construct(private readonly BlogQuestionService $blog)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:blog-question-read')->only('index');
        $this->middleware('permission:blog-question-show')->only('show');
        $this->middleware('permission:blog-question-update')->only('changeStatus');
        $this->middleware('permission:blog-question-delete')->only('destroy');
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
}
