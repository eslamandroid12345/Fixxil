<?php

namespace App\Http\Controllers\Api\V1\App\Comment;
use App\Http\Requests\Api\V1\App\Comment\CommentRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Comment\CommentService;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $comment,
    )
    {
        $this->middleware('auth:api-app');
    }

    public function store(CommentRequest $request)
    {
        return $this->comment->store($request);
    }

    public function update(CommentRequest $request, $id)
    {
        return $this->comment->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->comment->destroy($id);
    }
}
