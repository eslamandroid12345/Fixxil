<?php

namespace App\Http\Services\Api\V1\Dashboard\CustomerReview;

use App\Http\Requests\Api\V1\Dashboard\CustomerReview\CustomerReviewRequest;
use App\Http\Resources\V1\Dashboard\CustomerReview\CustomerReviewResource;
use App\Http\Resources\V1\Dashboard\CustomerReview\OneCustomerReviewResource;
use App\Http\Resources\V1\Dashboard\CustomerReview\CustomerReviewCollection;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\CustomerReviewRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CustomerReviewService
{
    use Responser;

    public function __construct(
        private readonly FileManagerService                $fileManagerService,
        private readonly GetService                        $get,
        private readonly CustomerReviewRepositoryInterface $customerReviewRepository,
    )
    {
    }

    public function index()
    {
        return $this->get->handle(CustomerReviewCollection::class, $this->customerReviewRepository,method:'paginate',is_instance: true);
    }

    public function show($id)
    {
        return $this->get->handle(OneCustomerReviewResource::class, $this->customerReviewRepository, 'getById', [$id], true);
    }

    public function store(CustomerReviewRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            if ($request->image)
                $data['image'] = $this->fileManagerService->handle('image', 'customer_reviews');
            $this->customerReviewRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created_successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function update(CustomerReviewRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $review = $this->customerReviewRepository->getById($id);
            if ($request->image)
                $data['image'] = $this->fileManagerService->handle('image', 'customer_reviews', target: $review->image);
            $this->customerReviewRepository->update($id, $data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated_successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $review = $this->customerReviewRepository->getById($id);
            if ($review->image)
                $this->fileManagerService->deleteFile($review->image);
            $this->customerReviewRepository->delete($id);
            DB::commit();
            return $this->responseSuccess(message: __('messages.deleted_successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
