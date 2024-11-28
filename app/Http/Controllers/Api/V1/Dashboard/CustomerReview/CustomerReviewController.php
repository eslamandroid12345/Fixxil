<?php

namespace App\Http\Controllers\Api\V1\Dashboard\CustomerReview;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\CustomerReview\CustomerReviewRequest;
use App\Http\Services\Api\V1\Dashboard\CustomerReview\CustomerReviewService;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    public function __construct(
        private readonly CustomerReviewService $customerReviewService
    )
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:review-read')->only('index' , 'show');
        $this->middleware('permission:review-create')->only('store');
        $this->middleware('permission:review-update')->only('update');
        $this->middleware('permission:review-delete')->only('destroy');
    }

    public function index()
    {
        return $this->customerReviewService->index();
    }

    public function show($id)
    {
        return $this->customerReviewService->show($id);
    }

    public function store(CustomerReviewRequest $request)
    {
        return $this->customerReviewService->store($request);
    }

    public function update($id, CustomerReviewRequest $request)
    {
        return $this->customerReviewService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->customerReviewService->destroy($id);
    }
}
