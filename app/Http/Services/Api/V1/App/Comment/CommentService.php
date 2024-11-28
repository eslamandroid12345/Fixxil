<?php

namespace App\Http\Services\Api\V1\App\Comment;

use App\Http\Requests\Api\V1\App\Comment\CommentRequest;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\CommentNotification;
use App\Repository\CommentRepositoryInterface;
use App\Repository\Eloquent\BlogRepository;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class CommentService extends PlatformService
{
    use Responser, Notification;

    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly BlogRepository             $blogRepository,
        private readonly FileManagerService         $fileManagerService,
        private readonly GetService                 $getService,
    )
    {
    }

    public function store(CommentRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->comment == null && $request->image == null) {
                return $this->responseFail(status: 422, message: 'Validation error');
            }
            $data = $request->only('blog_id');
            $data = array_merge($data, ["user_id" => auth('api-app')->id()]);
            if ($request->comment) {
                $data = array_merge($data, ["comment" => $request->comment]);
            }
            if ($request->hasFile('image')) {
                $data = array_merge($data, ["image" => $this->fileManagerService->handle("image", "blog/images")]);
            }
            $comment = $this->commentRepository->create($data);
            $blog = $this->blogRepository->getById($request->blog_id);
            if ($blog->user_id != auth('api-app')->id()) {
                $this->sendCommentNotification($data['blog_id']);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function sendCommentNotification($blog_id)
    {

        $blog = $this->blogRepository->getById($blog_id, columns: ['id', 'is_blog', 'user_id'], relations: ['user:id,fcm,name']);
        if ($blog->user?->id != auth('api-app')->id())
            $this->SendNotification(CommentNotification::class, $blog->user, [
                'user_name' => auth('api-app')->user()?->name,
                'blog_id' => $blog_id,
                'is_blog' => $blog->is_blog,
            ]);

    }

    public function update(CommentRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $comment = $this->commentRepository->getById($id);
            $data = $request->only('comment', 'blog_id');
            $data = array_merge($data, ["user_id" => auth('api - app')->id()]);
            $this->commentRepository->update($id, $data);
            DB::commit();
            return $this->responseSuccess(message: __('messages . updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages . Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try {
            $this->commentRepository->delete($id);
            return $this->responseSuccess(message: __('messages . deleted successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages . Something went wrong'));
        }
    }

}
