<?php

namespace App\Http\Services\Api\V1\App\Offer;

use App\Http\Requests\Api\V1\App\Offer\OfferRequest;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\PriceOfferNotification;
use App\Repository\OfferRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\InfoRepositoryInterface;
use App\Http\Resources\V1\App\Order\OfferForProviderResource;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

abstract class OfferService extends PlatformService
{
    use Responser, Notification;

    public function __construct(
        private readonly OfferRepositoryInterface $offerRepository,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly UserRepositoryInterface  $userRepository,
        private readonly InfoRepositoryInterface  $infoRepository,
        private readonly FileManagerService       $fileManagerService,
        private readonly GetService               $getService,
    )
    {
    }

    public function store(OfferRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $user = auth('api-app')->user();
            $info = $this->infoRepository->first('key', 'point_discount');
            if ($user->type != 'provider') {
                return $this->responseFail(status: 403, message: __('messages.user_not_have_permission'));
            }
            if ($user->wallet < $info->value)
            {
                return $this->responseFail(message: __('messages.the_wallet_amount_is_not_enough_pls_charge'));
            }
            $data = $request->validated();
            $data = array_merge($data, ["provider_id" => auth('api-app')->id()]);
            $order = $this->orderRepository->getById($request->order_id);
            $data = array_merge($data, ["customer_id" => $order->customer_id]);
            unset($data['price_type']);
            $this->offerRepository->create($data);
            $this->sendCustomerNotification($order);
            DB::commit();
            return $this->responseSuccess(message: __('messages.offer_added_successfully'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function sendCustomerNotification($order)
    {
        $user1 = $this->userRepository->getById(auth('api-app')->id());
        $user = $this->userRepository->getById($order->customer_id, ['id', 'name' ,'fcm']);
        $this->SendNotification(PriceOfferNotification::class, $user, [
            'user_name' => $user1->name,
            'order_id' => $order->id,
        ]);
    }

    public function getAllOffers()
    {
        // return $this->orderRepository->getOrdersForProvider(auth('api-app')->id());
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getById(auth('api-app')->id());
            return $this->getService->handle(OfferForProviderResource::class, $this->orderRepository, method: 'getOrdersForProvider', parameters: [$user->id]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
