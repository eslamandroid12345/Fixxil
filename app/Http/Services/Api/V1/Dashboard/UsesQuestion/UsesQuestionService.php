<?php

namespace App\Http\Services\Api\V1\Dashboard\UsesQuestion;

use App\Http\Requests\Api\V1\Dashboard\Uses\UsesRequest;
use App\Http\Requests\Api\V1\Dashboard\UsesQuestion\UsesQuestionRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\UsesRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\UsesQuestion\UsesQuestionResource;
use App\Http\Resources\V1\Dashboard\UsesQuestion\OneUsesQuestionResource;
use App\Http\Resources\V1\Dashboard\UsesQuestion\UsesQuestionCollection;

class UsesQuestionService
{
    use Responser;

    public function __construct(
        private readonly UsesRepositoryInterface $useRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index($use_id)
    {
        return $this->getService->handle(UsesQuestionCollection::class, $this->useRepository,'getAllQuestionForuses',parameters: [$use_id],is_instance: true);
    }

    public function store(UsesQuestionRequest $request,$use_id)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $data['parent_id'] = $use_id;
            $use = $this->useRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UsesQuestionResource($use));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($use_id,$id)
    {
        return $this->getService->handle(OneUsesQuestionResource::class, $this->useRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(UsesQuestionRequest $request, $use_id,$id)
    {
        try
        {
            $use = $this->useRepository->getById($id);
            $data = $request->validated();
            $this->useRepository->update($use->id, $data);
            $this->useRepository->update($id, ['updated_at' => now()]);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function destroy($use_id,$id)
    {
        try
        {
            $this->useRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
