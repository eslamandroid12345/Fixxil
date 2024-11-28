<?php

namespace App\Http\Services\Api\V1\App\Review;

use App\Http\Requests\Api\V1\App\Review\ReviewRequest;
use App\Http\Resources\V1\App\Review\ReviewCustomerResource;
use App\Http\Resources\V1\App\Review\ReviewProviderResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\OrderRepositoryInterface;
use App\Repository\ReviewRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReviewService
{
    use Responser;

    public function __construct(
        private readonly ReviewRepositoryInterface $reviewRepository,
        private readonly OrderRepositoryInterface  $orderRepository,
        private readonly GetService                $get,
    )
    {

    }

    public function store(ReviewRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $order = $this->orderRepository->getById($request->order_id, ['id', 'provider_id', 'customer_id']);
            if (!Gate::allows('add-rate', $order))
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $data = $request->only(['order_id', 'comment']);
            $data['provider_id'] = $order->provider_id;
            $data['customer_id'] = $order->customer_id;
            $review = $this->reviewRepository->create($data);
            if ($request->rates)
            {
                $this->attachRates($review, $request->rates);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.sended_successfully'));
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function udpate($request)
    {
        try {
            DB::beginTransaction();
            $review = $this->reviewRepository->getById($request->review_id);
            if (!Gate::allows('update-review', $review))
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $review->update(['comment' => $request->comment]);
            if ($request->rates)
                $this->attachRates($review, $request->rates);
            DB::commit();
            return $this->responseSuccess(message: __('messages.sended_successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function attachRates($review, $rates)
    {
        foreach ($rates as $rate) {
            $review->rates()?->create($rate);
        }
    }

    public function customerReviews()
    {
        return $this->get->handle(ReviewCustomerResource::class, $this->reviewRepository, 'getCustomerReviews');
    }

    public function providerReviews($id)
    {
        return $this->get->handle(ReviewProviderResource::class, $this->reviewRepository, 'getProviderReviews', [$id]);
    }
}
