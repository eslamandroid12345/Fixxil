<?php

namespace App\Http\Services\Api\V1\App\Wallet;

use App\Http\Resources\V1\App\Wallet\DepositDetailsResource;
use App\Http\Resources\V1\App\Wallet\PointDetailsResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\UserRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\WalletTransactionRepositoryInterface;
use App\Repository\UserPackageRepositoryInterface;
use App\Repository\PackageRepositoryInterface;
use App\Repository\InfoRepositoryInterface;
use Exception;
use App\Http\Requests\Api\V1\App\Wallet\ChargeRequest;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

abstract class WalletService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly WalletTransactionRepositoryInterface $walletTransactionRepository,
        private readonly OrderRepositoryInterface             $orderRepository,
        private readonly UserRepositoryInterface              $userRepository,
        private readonly InfoRepositoryInterface              $infoRepository,
        private readonly UserPackageRepositoryInterface       $userPackageRepository,
        private readonly PackageRepositoryInterface           $packageRepository,
        private readonly FileManagerService                   $fileManagerService,
        private readonly GetService                           $getService,
    )
    {
    }

    public function getPointDetails()
    {
        $id = auth('api-app')->id();
        $user = $this->userRepository->getById($id);
        return $this->getService->handle(PointDetailsResource::class, $this->orderRepository, 'getAllOrderFinishedProvider', parameters: [$user->id]);
    }

    public function charge(ChargeRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            $package = $this->packageRepository->getById($request->package_id);
            $info = $this->infoRepository->pointPrice();
            $total = $package->number * app(InfoRepositoryInterface::class)->pointPrice();
            $this->walletTransactionRepository->create([
                'user_id' => $user->id,
                'status' => 'deposit',
                'point_counter' => $package->number,
                'amount' => $total
            ]);
            $this->userRepository->update($user->id,['wallet' => $user->wallet + $package->number]);
            $this->userPackageRepository->create(['user_id' => $user->id , 'package_id' => $package->id]);
            // do payment in future
            DB::commit();
            return $this->responseSuccess(message: __('messages.charge successfully'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }

    }

    public function getTotalCharge(ChargeRequest $request)
    {
        $info = $this->infoRepository->first('key', 'point_price');
        $total = $request->point_counter * $info->value;
        return $this->responseSuccess(message: '', data: $total);
    }

    public function getAllDeposit()
    {
        $id = auth('api-app')->id();
        $user = $this->userRepository->getById($id);
        return $this->getService->handle(DepositDetailsResource::class, $this->walletTransactionRepository, 'getAllDeposit', parameters: [$user->id]);
    }

}
