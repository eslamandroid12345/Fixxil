<?php

namespace App\Http\Services\Api\V1\App\Order;

use App\Http\Enums\OfferStatus;
use App\Http\Enums\OrderNegotiateStatus;
use App\Http\Enums\OrderStatus;
use App\Http\Enums\UserType;
use App\Http\Requests\Api\V1\App\Order\OrderRequest;
use App\Http\Resources\V1\App\Chat\ChatProvideResource;
use App\Http\Resources\V1\App\Chat\ChatRoomOrderResource;
use App\Http\Resources\V1\App\Chat\ChatRoomResource;
use App\Http\Resources\V1\App\Order\OrderGeneralResource;
use App\Http\Resources\V1\App\Order\OrderNotHaveOfferCollection;
use App\Http\Resources\V1\App\Order\OrderProviderGeneralResource;
use App\Http\Resources\V1\App\Order\OrderResource;
use App\Http\Resources\V1\App\Order\OrderHasOfferResource;
use App\Http\Resources\V1\App\Order\OneOrderHasOfferResource;
use App\Http\Resources\V1\App\Order\OrderForUserResource;
use App\Http\Resources\V1\App\Order\NewOrderHomeResource;
use App\Http\Resources\V1\App\Order\OrderForProviderResource;
use App\Http\Resources\V1\App\Order\OrderNotHaveOfferResource;
use App\Http\Resources\V1\App\Order\NewOrdersCustomerResource;
use App\Http\Resources\V1\App\Order\OrderForCustomerResource;
use App\Http\Resources\V1\App\User\UserProfileResource;
use App\Http\Services\Api\V1\App\Order\Helpers\OrderChangeActionHelper;
use App\Http\Services\Api\V1\App\Order\Helpers\OrderNotificationsHelper;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderUpdateNotification;
use App\Notifications\OrderWithoutProviderNotification;
use App\Repository\InfoRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\OrderImageRepositoryInterface;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\OfferRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\NotificationRepositoryInterface;
use App\Repository\WalletTransactionRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

abstract class OrderService extends PlatformService
{
    use Responser;
    use Notification;

    const NOT_ACTIVE = 0;

    public function __construct(

        private readonly FileManagerService              $fileManager,
        private readonly OrderRepositoryInterface        $orderRepository,
        private readonly OrderImageRepositoryInterface   $orderimageRepository,
        private readonly UserRepositoryInterface         $userRepository,
        private readonly ManagerRepositoryInterface      $managerRepository,
        private readonly NotificationRepositoryInterface $notificationRepository,
        private readonly OfferRepositoryInterface        $offerRepository,
        private readonly ChatRoomRepositoryInterface     $chatRoomRepository,
        private readonly GetService                      $getService,
        private readonly OrderChangeActionHelper         $changeActionHelper,
        private readonly OrderNotificationsHelper        $notificationsHelper,
        private readonly WalletTransactionRepositoryInterface $walletTransactionRepository,
        private readonly InfoRepositoryInterface              $infoRepository,
    )
    {
    }

    public function changeAction($request)
    {
        return $this->changeActionHelper->changeAction($request);
    }

    public function request(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getById(auth('api-app')->id());
            if ($user->type != 'customer') {
                return $this->responseFail(status: 403, message: __('messages.user_not_have_permission'));
            }
            $data = $request->except(['images']);
            $data['customer_id'] = auth('api-app')->id();
            $data['status'] = OrderStatus::CREATED->value;
            $data['is_active'] = true;
            $order = $this->orderRepository->create($data);
            if ($request->images) {
                foreach ($request->images as $index => $image) {
                    $newImage = $this->fileManager->handle("images.$index", "order/images");
                    $this->orderimageRepository->create(['image' => $newImage, 'order_id' => $order->id]);
                }
            }
            $managers = $this->managerRepository->getAll();
            $this->SendNotification(OrderWithoutProviderNotification::class, $managers, [
                'customer' => $order->customer->name,
                'order_id' => $order->id,
            ]);
            $this->notificationsHelper->sendForProvidersInCategory($data['sub_category_id'], $order->id);
            $this->SendNotification(NewOrderNotification::class, $managers, [
                'order_id' => $order->id,
            ]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.Order has been placed successfully'), data: new OrderResource($order));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function requestProvider(OrderRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->except(['images']);
            $data['customer_id'] = auth('api-app')->id();
            $data['status'] = OrderStatus::AWAITING->value;
            $data['negotiate_status'] = OrderNegotiateStatus::UN_PRICED->value;
            $data['is_active'] = true;
            $order = $this->orderRepository->create($data);
            if ($request->images) {
                foreach ($request->images as $index => $image) {
                    $newImage = $this->fileManager->handle("images.$index", "order/images");
                    $this->orderimageRepository->create(['image' => $newImage, 'order_id' => $order->id]);
                }
            }
            $chat = $this->startChat($data['provider_id'], $order->id, 'CLOSE');
            $this->notificationsHelper->sendProviderNotification($data['provider_id'], $order->id);
            $managers = $this->managerRepository->getAll();
            $this->SendNotification(NewOrderNotification::class, $managers, [
                'order_id' => $order->id,
            ]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.Order has been placed successfully'), data: [
                'order' => OrderProviderGeneralResource::make($order),
                'chat' => $chat,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function chooseOffer($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $order = $this->orderRepository->getById($data['order_id']);
            $offer = $this->offerRepository->getById($data['offer_id'],relations: ['provider:id']);
            $this->orderRepository->update($data['order_id'], [
                'status' => OrderStatus::IN_PROGRESS->value,
                'provider_id' => $offer->provider_id,
                'price' => $offer->price,
                'point_counter' => app(InfoRepositoryInterface::class)->pointDiscount(),
                'at' => Carbon::now(),
            ]);
            foreach ($order->offers as $offer)
            {
                $offer->status = OfferStatus::REJECT->value;
                $offer->save();
            }
            $offer->status = OfferStatus::Accept->value;
            $offer->save();
            $chat = $this->startChat($offer->provider_id, $data['order_id'], 'OPEN');

            $this->userRepository->withdrawPointsFromWallet($order->provider_id);
            $user = $this->userRepository->getById(auth('api-app')->id());

            $managers = $this->managerRepository->getAll();
            $this->SendNotification(OrderUpdateNotification::class, $managers, [
                'message' => 'تم قبول الطلب',
                'order_id' => $order->id,
            ]);
            $this->SendNotification(OrderUpdateNotification::class, $offer->provider, [
                'message' => __('messages.Your offer is accepted'),
                'order_id' => $order->id,
            ]);
            DB::commit();
            return $this->responseSuccess(data: [
                'order' => OrderGeneralResource::make($order),
                'chat' => $chat,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function startChat($provider_id, $order_id, $status)
    {
        return ChatRoomOrderResource::make($this->chatRoomRepository->provide($provider_id, $order_id, $status));
    }

    public function hasOffers()
    {
        return $this->getService->handle(OrderHasOfferResource::class, $this->orderRepository, 'getOrderHasOffers');
    }

    public function oneOrderHasOffer($id)
    {
        return $this->getService->handle(OneOrderHasOfferResource::class, $this->orderRepository, 'getById', parameters: [$id, ['*'], ['offers.unit']], is_instance: true);
    }

    public function getOrderForUser(Request $request)
    {
        $id = auth('api-app')->id();
        $user = $this->userRepository->getById($id);
        return $this->getService->handle(OrderForUserResource::class, $this->orderRepository, 'getOrderForUser', parameters: [$id, $request->status]);
    }

    public function showOneOrder($id)
    {
        $order = $this->orderRepository->getById($id, relations: ['myOffers']);
        return $this->responseSuccess(data: OrderProviderGeneralResource::make($order));
    }

    public function getOrders(Request $request)
    {
        $id = auth('api-app')->id();
        $user = $this->userRepository->getById($id);
        return $this->getService->handle(NewOrderHomeResource::class, $this->orderRepository, 'getOrderForProvider', parameters: [$id, $request->status]);
    }

    public function getOrdersHome()
    {
        return $this->getService->handle(OrderNotHaveOfferResource::class, $this->orderRepository, 'getNewOrderForProviderHome');
    }

    public function getOneNewOrder($id)
    {
        $order = $this->orderRepository->getById($id, relations: ['myOffers']);
        $chat = null;
        if ($order->provider_id)
            $chat = ChatRoomOrderResource::make($this->chatRoomRepository->provide($order->provider_id, $order->id));
        return $this->responseSuccess(data: [
            'order' => OrderProviderGeneralResource::make($order),
            'chat' => $chat,
        ]);
    }

    public function cancelOrder($id)
    {
        try {
            if (auth('api-app')->user()?->type != UserType::CUSTOMER->value) {
                return $this->responseFail(status: 403, message: __('messages.user_not_have_permission'));
            }
            $this->orderRepository->update($id, ['is_active' => self::NOT_ACTIVE]);
            return $this->responseSuccess(message: __('messages.Order was canceled Successfully'));
        } catch (Exception $exception) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getOrderNotHavOffer()
    {
        $id = auth('api-app')->id();
        return $this->getService->handle(OrderNotHaveOfferCollection::class, $this->orderRepository, 'getOrderNotHavOffer', parameters: [$id], is_instance: true);
    }

    public function getOrdersCustomer(Request $request)
    {
        $id = auth('api-app')->id();
        $user = $this->userRepository->getById($id);
        return $this->getService->handle(NewOrdersCustomerResource::class, $this->orderRepository, 'getOrdersForCustomer', parameters: [$user->id, $request->status]);
    }

    public function getOneNewOrderCustomer($id)
    {
        $order = $this->orderRepository->getById($id);
        if ($order->provider_id != null) {
            $chat = $this->chatRoomRepository->provide($order->provider_id, $order->id);
            return $this->responseSuccess(data: [
                'order' => OrderProviderGeneralResource::make($order),
                'chat' => $chat != null ? ChatRoomOrderResource::make($chat) : [],
            ]);
        } else {
            return $this->responseSuccess(data: [
                'order' => OrderProviderGeneralResource::make($order),
                'chat' => [],
            ]);
        }
    }

}
