<?php

namespace App\Http\Services\Api\V1\Dashboard\Question;

use App\Repository\QuestionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Helpers\Http;
use Illuminate\Http\Request;
use App\Http\Resources\V1\Dashboard\Question\QuestionCollection;
use App\Http\Resources\V1\Dashboard\Question\OneQuestionResource;
use App\Http\Resources\V1\Dashboard\Question\QuestionResource;

class QuestionService
{
    use Responser;

    public function __construct(
        private readonly QuestionRepositoryInterface $questionRepository,
        private readonly GetService                     $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(QuestionCollection::class, $this->questionRepository,method: 'paginate' ,is_instance: true);
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $question = $this->questionRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new QuestionResource($question));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(OneQuestionResource::class, $this->questionRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update($request, $id)
    {
        try
        {
            $question = $this->questionRepository->getById($id);
            $data = $request->validated();
            $data['is_active'] = $request->is_active ? true : false;
            $this->questionRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
    public function destroy($id)
    {
        try
        {
            $this->questionRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
    public function changeStatus(Request $request,$id)
    {
        try
        {
            $user = $this->questionRepository->getById($id);
            $this->questionRepository->update($id, ["is_active" => $request->is_active]);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
