<?php

namespace App\Http\Controllers\Api\V1\App\Structure;

use App\Http\Controllers\Api\V1\App\Structure\StructureController;
use App\Http\Requests\Api\V1\Dashboard\Structure\AboutUsRequest;
use App\Http\Resources\V1\App\Blog\BlogGeneralResource;
use App\Http\Resources\V1\App\Blog\BlogResource;
use App\Http\Resources\V1\App\Category\CategoryGeneralResource;
use App\Http\Resources\V1\App\Category\CategoryResource;
use App\Http\Resources\V1\App\CustomerReview\CustomerReviewResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\Mutual\HelperService;
use App\Http\Traits\Responser;
use App\Repository\BlogRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\CustomerReviewRepositoryInterface;
use App\Repository\StructureRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends StructureController
{
    use Responser;

    protected string $contentKey = 'home';
    protected array $locales = ['en', 'ar'];

    public function __construct(
        StructureRepositoryInterface                       $structureRepository,
        FileManagerService                                 $fileManagerService,
        HelperService                                      $helper, GetService $getService,
        private readonly CategoryRepositoryInterface       $categoryRepository,
        private readonly BlogRepositoryInterface           $blogRepository,
        private readonly CustomerReviewRepositoryInterface $customerReviewRepository,
    )
    {
        parent::__construct($structureRepository, $fileManagerService, $helper, $getService);

    }

    public function index(Request $request)
    {
        $content = json_decode($this->structureRepository->structure($this->contentKey)?->content, true);
        $language = $request->header('Accept-Language');
        return $this->responseSuccess(data: [
            'content' => $content[$language],
        ]);
    }
}
