<?php

namespace App\Http\Services\Api\V1\App\Question;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\QuestionRateRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\V1\App\Question\QuestionRequest;
use App\Http\Resources\V1\App\Question\QuestionResource;
use App\Http\Resources\V1\App\Question\QuestionRateResource;

abstract class QuestionService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly QuestionRepositoryInterface   $questionRepository,
        private readonly QuestionRateRepositoryInterface   $questionRateRepository,
        private readonly OrderRepositoryInterface   $orderRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(QuestionResource::class, $this->questionRepository, 'getActive');
    }

    public function store(QuestionRequest $request)
    {
        try
        {
            DB::beginTransaction();
//            $data = $request->validated();
            foreach($request->rate as $rate)
            {
                $data['question_id'] = $rate['question_id'];
                $data['rate'] = $rate['rate'];
                $data['order_id'] = $request->order_id;
                $data['customer_id'] = auth('api-app')->id();
                $order = $this->orderRepository->getById($request->order_id);
                $data['provider_id'] = $order->provider_id;
                $questionrate = $this->questionRateRepository->create($data);
            }
            if($request->comment)
            {
                $data1['comment'] = $request->comment;
                $data1['customer_id'] = auth('api-app')->id();
                $order = $this->orderRepository->getById($request->order_id);
                $data1['provider_id'] = $order->provider_id;
                $data1['order_id'] = $order->id;
                $questionrate = $this->questionRateRepository->create($data1);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
