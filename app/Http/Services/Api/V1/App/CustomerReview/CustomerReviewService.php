<?php

namespace App\Http\Services\Api\V1\App\CustomerReview;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\CustomerReviewRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\CustomerReview\CustomerReviewResource;

abstract class CustomerReviewService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly CustomerReviewRepositoryInterface    $customerreviewRepository,
        private readonly GetService                     $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(CustomerReviewResource::class, $this->customerreviewRepository);
    }

}
