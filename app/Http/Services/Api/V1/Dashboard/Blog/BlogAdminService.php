<?php

namespace App\Http\Services\Api\V1\Dashboard\Blog;

use App\Http\Requests\Api\V1\App\Blog\BlogRequest;
use App\Http\Requests\Api\V1\Dashboard\Blog\BlogImageRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\BlogImageRepositoryInterface;
use App\Repository\BlogRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Traits\Notification;
use App\Http\Resources\V1\Dashboard\Blog\BlogAdminCollection;
use App\Http\Resources\V1\Dashboard\Blog\BlogAdminResource;
use App\Http\Resources\V1\Dashboard\Blog\BlogAdminCommentResource;
use App\Repository\CommentRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Notifications\DeleteCommentNotification;
use Illuminate\Support\Facades\DB;

class BlogAdminService
{
    use Responser,Notification;

    public function __construct(
        private readonly BlogRepositoryInterface $blogRepository,
        private readonly BlogImageRepositoryInterface $blogImageRepository,
        private readonly ManagerRepositoryInterface $managerRepository,
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService              $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(BlogAdminCollection::class, $this->blogRepository,method: 'getAllBlogsAdmin',is_instance: true);
    }

    public function store(BlogRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->only('content', 'title', 'category_id');
            $manager = $this->managerRepository->getById(auth('api-manager')->id());
            $data = array_merge($data, ["is_blog" => 1 , "is_published" => 1, "manager_id" => $manager->id]);
            $blog = $this->blogRepository->create($data);
            if($request->images)
            {
                $this->uploadImages($request, $blog);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    protected function uploadImages(BlogRequest $request, $blog): void
    {
        if ($request->hasFile('images'))
        {
            foreach ($request->images as $index => $image)
            {
                $newImage = $this->fileManagerService->handle("images.$index", "blog/images");
                $this->blogImageRepository->create(['image' => $newImage, 'blog_id' => $blog->id]);
            }
        }
    }

    public function show($id)
    {
        return $this->getService->handle(BlogAdminResource::class, $this->blogRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(BlogRequest $request,$id)
    {
        DB::beginTransaction();
        try
        {
            $blog = $this->blogRepository->getById($id);
            $data = $request->only('content', 'title', 'category_id');
            $manager = $this->managerRepository->getById(auth('api-manager')->id());
            $data = array_merge($data, ["manager_id" => $manager->id]);
            $this->blogRepository->update($blog->id,$data);
            if ($request->images)
            {
                foreach ($blog->images as $image)
                {
                    $image->delete();
                }
                $this->uploadImages($request, $blog);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->blogRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function deleteComment($id)
    {
        DB::beginTransaction();
        try
        {
            $comment = $this->commentRepository->getById($id);
            $this->SendNotification(DeleteCommentNotification::class, $comment->user, [
                'blog_id' => $comment->blog->id,
                'is_blog' => $comment->blog->is_blog,
            ]);
            $this->commentRepository->delete($id);
            DB::commit();
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
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
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getCommentForBlog($id)
    {
        return $this->getService->handle(BlogAdminCommentResource::class, $this->blogRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function deleteImage($id)
    {
        try
        {
            $this->blogImageRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function storeImages(BlogImageRequest $request,$id)
    {
        DB::beginTransaction();
        try
        {
            $blog = $this->blogRepository->getById($id);
            if ($request->hasFile('images'))
            {
                foreach ($request->images as $index => $image) {
                    $newImage = $this->fileManagerService->handle("images.$index", "blog/images");
                    $this->blogImageRepository->create(['image' => $newImage, 'blog_id' => $blog->id]);
                }
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
