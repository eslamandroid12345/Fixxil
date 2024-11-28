<?php

namespace App\Http\Services\Api\V1\Dashboard\Changes;

use App\Http\Enums\ChangeTypeEnum;
use App\Http\Resources\V1\Dashboard\Changes\ChangesCollection;
use App\Http\Resources\V1\Dashboard\Changes\Types\UserImagesChangesResource;
use App\Http\Resources\V1\Dashboard\Changes\Types\UserMainDataChangesResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\ConfirmUpdateUserDataNotification;
use App\Notifications\RejectUpdateUserDataNotification;
use App\Repository\ChangeRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChangesService
{
    use Responser, Notification;

    public function __construct(
        private readonly GetService                $getService,
        private readonly ChangeRepositoryInterface $repository,
        private readonly UserRepositoryInterface   $userRepository,
    )
    {

    }

    public function index()
    {
        return $this->getService->handle(ChangesCollection::class, $this->repository, method: 'paginateChangesDashboard', is_instance: true);
    }

    public function show($id)
    {
        $change = $this->repository->getById($id, relations: ['user:id,name']);
        if ($change->type == ChangeTypeEnum::MAIN_DETAILS->value)
            $data = UserMainDataChangesResource::make(json_decode($change->data, true));
        else if ($change->type == ChangeTypeEnum::SERVICE_IMAGES->value)
            $data = UserImagesChangesResource::collection(json_decode($change->data));
        return $this->responseSuccess(data: [
            'user_name' => $change->user?->name,
            'type' => $change->type,
            'content' => $data
        ]);
    }

    public function approve($id)
    {
        $change = $this->repository->getById($id);
        try {
            DB::beginTransaction();
            $user = $this->userRepository->getById($change->user_id);
            if ($change->type == ChangeTypeEnum::MAIN_DETAILS->value)
                $this->approveUserMainData($user, json_decode($change->data, true));
            else if ($change->type == ChangeTypeEnum::SERVICE_IMAGES->value)
                $this->approveUserImages($user, json_decode($change->data, true));
            $change->delete();
            $this->SendNotification(ConfirmUpdateUserDataNotification::class, $user);
            DB::commit();
            return $this->responseSuccess();
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));

        }
    }

    private function approveUserMainData($user, $data)
    {
        $user->update($data);
    }

    private function approveUserImages($user, $images)
    {
        $user->serviceImages()?->delete();
        foreach ($images as $image) {
            $user->serviceImages()->create(['image' => $image['path']]);
        }
    }

    public function reject($id)
    {
        $change = $this->repository->getById($id, ['id','user_id']);
        try {
            DB::beginTransaction();
            $user = $this->userRepository->getById($change->user_id, ['id']);
            $this->repository->delete($id);
            $this->SendNotification(RejectUpdateUserDataNotification::class, $user);
            DB::commit();
            return $this->responseSuccess();
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
