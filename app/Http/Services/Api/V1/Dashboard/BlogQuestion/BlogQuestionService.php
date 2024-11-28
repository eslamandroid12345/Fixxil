<?php

namespace App\Http\Services\Api\V1\Dashboard\BlogQuestion;

use App\Repository\BlogRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Traits\Notification;
use App\Http\Resources\V1\Dashboard\Blog\BlogResource;
use App\Http\Resources\V1\Dashboard\Blog\BlogCollection;
use App\Notifications\AcceptQuestionNotification;

class BlogQuestionService
{
    use Responser,Notification;

    public function __construct(
        private readonly BlogRepositoryInterface $blogRepository,
        private readonly GetService              $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(BlogCollection::class, $this->blogRepository,method: 'getAllQuestionsDashboard',is_instance: true);
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

    public function changeStatus($request,$id)
    {
        try
        {
            $blog = $this->blogRepository->getById($id);
            $data['is_published'] = $request->is_published ? true : false;
            $this->blogRepository->update($blog->id, $data);
            if($request->is_published)
            {
                $this->SendNotification(AcceptQuestionNotification::class, $blog->user, [
                    'question_id' => $blog->id,
                ]);
            }
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
