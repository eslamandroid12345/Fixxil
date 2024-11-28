<?php

namespace App\Http\Services\Api\V1\Dashboard\Uses;

use App\Http\Requests\Api\V1\Dashboard\Uses\UsesRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\UsesRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Uses\UsesResource;
use App\Http\Resources\V1\Dashboard\Uses\OneUsesResource;
use App\Http\Resources\V1\Dashboard\Uses\UsesCollection;

class UsesService
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
        return $this->getService->handle(UsesCollection::class, $this->useRepository,'getAllUsesForCategory',parameters: [$use_id],is_instance: true);
    }

    public function store(UsesRequest $request,$usecategory_id)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $data['use_category_id'] = $usecategory_id;
            $use = $this->useRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UsesResource($use));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($usecategory_id,$id)
    {
        return $this->getService->handle(OneUsesResource::class, $this->useRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(UsesRequest $request, $usecategory_id,$id)
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

    public function destroy($usecategory_id,$id)
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
