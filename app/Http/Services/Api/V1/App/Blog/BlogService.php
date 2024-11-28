<?php

namespace App\Http\Services\Api\V1\App\Blog;

use App\Http\Requests\Api\V1\App\Blog\BlogRequest;
use App\Http\Resources\V1\Dashboard\Blog\BlogCollection;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\BlogNotification;
use App\Notifications\QuestionNotification;
use App\Repository\BlogRepositoryInterface;
use App\Repository\BlogImageRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Blog\BlogResource;

abstract class BlogService extends PlatformService
{
    use Responser,Notification;

    public function __construct(
        private readonly BlogRepositoryInterface      $blogRepository,
        private readonly BlogImageRepositoryInterface $blogImageRepository,
        private readonly UserRepositoryInterface      $userRepository,
        private readonly ManagerRepositoryInterface      $managerRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function store(BlogRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->only('content', 'title', 'category_id');
            $data['is_blog'] = $request->is_blog ? true : false;
            $user = $this->userRepository->getById(auth('api-app')->id());
            $data = array_merge($data, ["user_id" => $user->id]);
            if($user->type == 'customer' && $request->is_blog)
            {
                return $this->responseFail(message: __('messages.You are not authorized to access this Package'));
            }
            $blog = $this->blogRepository->create($data);
            $this->uploadImages($request, $blog);
            DB::commit();
            $managers = $this->managerRepository->getAll();
            if($blog->is_blog == true)
            {
                $this->SendNotification(BlogNotification::class, $managers, [
                    'blog_id' => $blog->id,
                ]);
            }
            else
            {
                $this->SendNotification(QuestionNotification::class, $managers, [
                    'question_id' => $blog->id,
                ]);
            }
            return $this->responseSuccess(message: __('messages.created successfully and wait review'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    protected function uploadImages(BlogRequest $request, $blog): void
    {
        if ($request->hasFile('images')) {
            foreach ($request->images as $index => $image) {
                $newImage = $this->fileManagerService->handle("images.$index", "blog/images");
                $this->blogImageRepository->create(['image' => $newImage, 'blog_id' => $blog->id]);
            }
        }
    }

    public function index()
    {
        return $this->getService->handle(BlogCollection::class, $this->blogRepository, 'getAllBlogs', parameters: [true],is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(BlogResource::class, $this->blogRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function getAllBlogQuestions()
    {
        return $this->getService->handle(BlogCollection::class, $this->blogRepository, 'getAllQuestions',is_instance: true);
    }

    public function getBlogsForHome()
    {
        return $this->getService->handle(BlogResource::class, $this->blogRepository, 'getBlogsForHome');
    }

}
