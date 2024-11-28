<?php

namespace App\Http\Services\Api\V1\App\Negotiates;

use App\Events\ButtonsChangedEvent;
use App\Events\ChatRoomStatusChange;
use App\Events\PushChatMessageEvent;
use App\Http\Enums\OrderNegotiateStatus;
use App\Http\Enums\OrderStatus;
use App\Http\Resources\V1\App\Chat\ChatMessageResource;
use App\Http\Services\Api\V1\App\Negotiates\Helper\OfferPriceHelperService;
use App\Http\Services\Api\V1\App\Negotiates\Helper\OrderUpdatesNotificationHelperService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\OrderUpdateNotification;
use App\Repository\ChatRoomMessageRepositoryInterface;
use App\Repository\Eloquent\ChatRoomRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\WalletTransactionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

abstract class NegotiatesService extends PlatformService
{
    use Responser,Notification;

    const HAS_DISCOUNT = 1;

    public function __construct(
        private ChatRoomRepository                 $roomRepository,
        private OrderRepositoryInterface           $orderRepository,
        private ChatRoomMessageRepositoryInterface $messageRepository,
        private UserRepositoryInterface            $userRepository,
        private OfferPriceHelperService            $offerPriceHelperService,
        private OrderUpdatesNotificationHelperService            $notificationHelperService,
        private readonly ManagerRepositoryInterface      $managerRepository,
        private readonly WalletTransactionRepositoryInterface $walletTransactionRepository,
        private readonly InfoRepositoryInterface              $infoRepository,
    )
    {

    }

    public function negotiate($request)
    {
        $data = $request->validated();
        $order = $this->orderRepository->getById($data['order_id'],['*'],['customer','provider']);
        switch ($data['negotiate_type']) {
            case 'accept_offer' :
                return $this->acceptOffer($order);
            case 'cansel_service' :
                return $this->canselService($order);
            case 'offer_price' :
                return $this->offerPrice($order, $data);
            case 'ask_for_discount' :
                return $this->askForDiscount($order);
            case 'discount' :
                return $this->discount($order, $data['price']);
            case 'fix_the_price' :
                return $this->fixThePrice($order);
            case 'go_to_location' :
                return $this->goToLocation($order, $data['negotiate_type']);
            case 'start_service' :
                return $this->startService($order, $data['negotiate_type']);
            case 'finish_service' :
                return $this->finishService($order, $data['negotiate_type']);
        }
        return 0;
    }

    private function goToLocation($order, $action)
    {
        try {
            DB::beginTransaction();
            if (!$order->canGoToLocation)
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $order->update(['action' => $action]);
            DB::commit();
            $message = "تم التوجه للموقع .";
            $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
            return $this->sendMessageInRoom($order->id, $message, true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function startService($order, $action)
    {
        try {
            DB::beginTransaction();
            if (!$order->canStartService)
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $order->update(['action' => $action]);
            DB::commit();
            $message = "تم بدء الخدمه";
            $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
            return $this->sendMessageInRoom($order->id, $message, true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function finishService($order, $action)
    {
        try {
            DB::beginTransaction();
            if (!$order->canFinishService)
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $order->update([
                'action' => $action,
                'status' => OrderStatus::FINISHED->value]);
            $room = $this->roomRepository->getRoomByOrder($order->id);
            $room->update(['status' => 'CLOSE']);
            broadcast(new ChatRoomStatusChange($room->id, 'CLOSE'))->toOthers();
            DB::commit();
            $message = "تم انهاء الخدمه";
            $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
            return $this->sendMessageInRoom($order->id, $message);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function acceptOffer($order)
    {
        try
        {
            DB::beginTransaction();
            if (!$order->canAcceptOrder)
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $this->userRepository->withdrawPointsFromWallet($order->provider_id);
            $order->update([
                                'status' => OrderStatus::IN_PROGRESS->value,
                                'point_counter' => app(InfoRepositoryInterface::class)->pointDiscount(),
                            ]);
            $total = app(InfoRepositoryInterface::class)->pointDiscount() * app(InfoRepositoryInterface::class)->pointPrice();
            $this->walletTransactionRepository->create([
                                                            'user_id' => $order->provider_id,
                                                            'status' => 'withdraw',
                                                            'point_counter' => app(InfoRepositoryInterface::class)->pointDiscount(),
                                                            'amount' => $total
                                                        ]);
            $message = "موافق علي السعر";
            $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);

            $managers = $this->managerRepository->getAll();
            $this->SendNotification(OrderUpdateNotification::class, $managers, [
                'message' => '  تم الموافقه على الطلب ',
                'order_id' => $order->id,
            ]);
        DB::commit();
        return $this->sendMessageInRoom($order->id, $message, true);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function canselService($order)
    {
        if (!$order->canCanselOrder)
            return $this->responseFail(message: __('messages.you are not authorized to do this action'));
        $order->update([
            'status' => OrderStatus::CANCELED->value,
        ]);
        $message = "تم الغاء الخدمه";
        $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
        return $this->sendMessageInRoom($order->id, $message);
    }

    private function offerPrice($order, $data)
    {
        if (!$order->canOfferPrice)
            return $this->responseFail(message: __('messages.you are not authorized to do this action'));
        $message = $this->offerPriceHelperService->getOfferPriceMessage($order, $data);
        $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
        return $this->sendMessageInRoom($order->id, $message);
    }

    private function askForDiscount($order)
    {
        if (!$order->canRequestDiscount)
            return $this->responseFail(message: __('messages.you are not authorized to do this action'));
        $order->update([
            'negotiate_status' => OrderNegotiateStatus::NEED_CHANGE->value,
        ]);
        $message = "طلب تخفيض السعر";
        $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
        return $this->sendMessageInRoom($order->id, $message);
    }

    private function discount($order, $price)
    {
        if (!$order->canDiscount)
            return $this->responseFail(message: __('messages.you are not authorized to do this action'));
        $order->update([
            'price' => $price,
            'has_discount_before' => self::HAS_DISCOUNT,
        ]);
        $message = "السعر بعد التخفيض $price جنيه";
        $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
        return $this->sendMessageInRoom($order->id, $message);
    }

    private function fixThePrice($order)
    {
        if (!$order->canFixThePrice)
            return $this->responseFail(message: __('messages.you are not authorized to do this action'));
        $order->update([
            'negotiate_status' => OrderNegotiateStatus::FIXED_PRICE->value,
        ]);
        $message = "السعر غير قابل للتفاوض ";
        $this->notificationHelperService->sendOrderUpdateNotification(order: $order,message: $message);
        return $this->sendMessageInRoom($order->id, $message);
    }

    private function sendMessageInRoom($order_id, $message_content = '', $chat_opened = false)
    {
        try {
            DB::beginTransaction();
            $room = $this->roomRepository->getRoomByOrder($order_id);
            $message = $this->messageRepository->create([
                'chat_room_id' => $room?->id,
                'user_id' => auth('api-app')->id(),
                'content' => $message_content,
                'type' => 'TEXT',
            ]);
            if ($chat_opened) {
                $room->update(['status' => 'OPEN']);
                broadcast(new ChatRoomStatusChange($room->id, 'OPEN'))->toOthers();
            }
            broadcast(new PushChatMessageEvent($message))->toOthers();
            broadcast(new ButtonsChangedEvent(true, $room?->id))->toOthers();
            DB::commit();
            return $this->responseSuccess(data: [
                'chat_opened' => $chat_opened,
                'message' => ChatMessageResource::make($message)]);
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
