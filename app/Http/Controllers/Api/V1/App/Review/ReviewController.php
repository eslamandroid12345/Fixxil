<?php

namespace App\Http\Controllers\Api\V1\App\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Review\ReviewRequest;
use App\Http\Requests\Api\V1\App\Review\UpdateReviewRequest;
use App\Http\Services\Api\V1\App\Review\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ReviewService $reviewService
    ){
        $this->middleware('auth:api-app');
    }
    public function store(ReviewRequest $request)
    {
        return $this->reviewService->store($request);
    }
    public function update(UpdateReviewRequest $request){
        return $this->reviewService->udpate($request);
    }
    public function customerReviews(){
        return $this->reviewService->customerReviews();
    }
    public function providerReviews($id){
        return $this->reviewService->providerReviews($id);
    }
}
