<?php

namespace App\Http\Services\Api\V1\Dashboard\Blog;

use App\Http\Resources\V1\Dashboard\Comment\CommentCollection;
use App\Repository\BlogRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Traits\Notification;
use App\Notifications\DeleteCommentNotification;
use App\Http\Resources\V1\Dashboard\Blog\BlogResource;
use App\Http\Resources\V1\Dashboard\Blog\BlogCollection;
use App\Repository\CommentRepositoryInterface;
use App\Notifications\AcceptBlogNotification;

class BlogService
{
    use Responser,Notification;

    public function __construct(
        private readonly BlogRepositoryInterface $blogRepository,
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly GetService              $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(BlogCollection::class, $this->blogRepository,method: 'getAllBlogs',is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(BlogResource::class, $this->blogRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function destroy($id)
    {
        try {
            $this->blogRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function deleteComment($id)
    {
        try
        {
            $comment = $this->commentRepository->getById($id);
            $this->SendNotification(DeleteCommentNotification::class, $comment->user, [
                'blog_id' => $comment->blog->id,
                'is_blog' => $comment->blog->is_blog,
            ]);
            $this->commentRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($request,$id)
    {
        try
        {
            $blog = $this->blogRepository->getById($id);
            $data['is_published'] = $request->is_published ? true : false;
            $this->blogRepository->update($blog->id, $data);
            if($request->is_published)
            {
                $this->SendNotification(AcceptBlogNotification::class, $blog->user, [
                    'blog_id' => $blog->id,
                ]);
            }
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
    public function getAllComments()
    {
        return $this->getService->handle(CommentCollection::class, $this->commentRepository,method: 'paginateCommentsDashboard',is_instance: true);
    }
}
