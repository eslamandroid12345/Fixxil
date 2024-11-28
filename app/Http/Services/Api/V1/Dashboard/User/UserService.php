<?php

namespace App\Http\Services\Api\V1\Dashboard\User;

use App\Http\Traits\Notification;
use App\Models\UserServiceImage;
use App\Notifications\DecreasePointNotification;
use App\Notifications\IncreasePointNotification;
use App\Repository\Eloquent\UserServiceImageRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\WalletTransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Helpers\Http;
use Illuminate\Http\Request;
use App\Http\Resources\V1\Dashboard\User\UserCollection;
use App\Http\Resources\V1\Dashboard\User\UserResource;
use App\Http\Resources\V1\Dashboard\User\OneUserResource;
use App\Http\Requests\Api\V1\User\AddPointRequest;

class UserService
{
    use Responser,Notification;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly WalletTransactionRepositoryInterface $walletTransactionRepository,
        private readonly UserServiceImageRepository $userServiceImageRepository,
        private readonly GetService                     $getService,
    )
    {
    }

    public function index()
    {
//        return $this->getService->handle(UserCollection::class, $this->userRepository,method: 'paginate' ,is_instance: true);
        return $this->getService->handle(UserCollection::class, $this->userRepository,method: 'getAllUsers' ,is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(OneUserResource::class, $this->userRepository, method: 'getById', parameters: [$id], is_instance: true);
    }
    public function destroy($id)
    {
        try
        {
            $this->userRepository->delete($id);
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
            $user = $this->userRepository->getById($id);
            $this->userRepository->update($id, ["is_active" => $request->is_active]);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function deleteImage($id)
    {
        try
        {
            $this->userServiceImageRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function increasePoint(AddPointRequest $request,$id)
    {
        try
        {
            DB::beginTransaction();
            $user = $this->userRepository->getById($id);
            $this->userRepository->update($id, ["wallet" => $user->wallet + $request->wallet]);
            $total = $request->wallet * app(InfoRepositoryInterface::class)->pointPrice();
            $this->walletTransactionRepository->create([
                'user_id' => $user->id,
                'status' => 'deposit',
                'point_counter' => $request->wallet,
                'amount' => 0,
                'reason' => $request->reason,
            ]);
            $this->SendNotification(IncreasePointNotification::class, $user, [
                'user_id' => $user->id,
                'reason' => $request->reason,
                'amount' => $request->wallet,
            ]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function decreasePoint(AddPointRequest $request,$id)
    {
        try
        {
            DB::beginTransaction();
            $user = $this->userRepository->getById($id);
            $this->userRepository->update($id, ["wallet" => $user->wallet - $request->wallet]);

            $total = $request->wallet * app(InfoRepositoryInterface::class)->pointPrice();
            $this->walletTransactionRepository->create([
                'user_id' => $user->id,
                'status' => 'withdraw',
                'point_counter' => $request->wallet,
                'amount' => 0,
                'reason' => $request->reason,
            ]);
            $this->SendNotification(DecreasePointNotification::class, $user, [
                'user_id' => $user->id,
                'reason' => $request->reason,
                'amount' => $request->wallet,
            ]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
