<?php

namespace App\Http\Services\Api\V1\Dashboard\Order;

use App\Events\ChatRoomStatusChange;
use App\Http\Resources\V1\Dashboard\Order\OneOrderMessageResource;
use App\Http\Traits\Notification;
use App\Notifications\OrderActiveNotification;
use App\Notifications\OrderCancelNotification;
use App\Notifications\OrderDeActiveNotification;
use App\Notifications\OrderUnCancelNotification;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Helpers\Http;
use Illuminate\Http\Request;
use App\Http\Resources\V1\Dashboard\Order\OrderCollection;
use App\Http\Resources\V1\Dashboard\Order\OrderResource;
use App\Http\Resources\V1\Dashboard\Order\OneOrderResource;

class OrderService
{

    use Responser,Notification;

    const NOT_STOPPED = 0;
    const STOPPED = 1;

    public function __construct(
        private readonly OrderRepositoryInterface    $orderRepository,
        private readonly ChatRoomRepositoryInterface $chatRoomRepository,
        private readonly GetService                  $getService,
    )
    {
    }

    public function index(Request $request)
    {
        return $this->getService->handle(OrderCollection::class, $this->orderRepository, method: 'getAllOrderDashboard', parameters: [$request->status, $request->rank], is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(OneOrderResource::class, $this->orderRepository, method: 'getById', parameters: [$id, ['*'], ['subCategory', 'images', 'messages.user']], is_instance: true);
    }

    public function getOrderMessage($id)
    {
        return $this->getService->handle(OneOrderMessageResource::class, $this->orderRepository, method: 'getById', parameters: [$id, ['*'], ['subCategory', 'images', 'messages.user']], is_instance: true);
    }

    public function destroy($id)
    {
        try {
            $this->orderRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $order = $this->orderRepository->getById($id);
            $this->orderRepository->update($id, ["is_active" => $request->is_active]);
            $order = $this->orderRepository->getById($id);
            if($order->is_active == 1)
            {
                $this->SendNotification(OrderActiveNotification::class, $order->customer, [
                    'order_id' => $order->id,
                ]);
                $this->SendNotification(OrderActiveNotification::class, $order->provider, [
                    'order_id' => $order->id,
                ]);
            }
            else
            {
                $this->SendNotification(OrderDeActiveNotification::class, $order->customer, [
                    'order_id' => $order->id,
                ]);
                $this->SendNotification(OrderDeActiveNotification::class, $order->provider, [
                    'order_id' => $order->id,
                ]);
            }
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function stop($id)
    {
        try
        {
            DB::beginTransaction();
            $order = $this->orderRepository->getById($id);
            $this->updateChatStatus($order);
            $this->orderRepository->update($id, ["is_stopped" => !$order->is_stopped]);
            $order = $this->orderRepository->getById($id);
            if($order->is_stopped == 1)
            {
                $this->SendNotification(OrderCancelNotification::class, $order->customer, [
                    'order_id' => $order->id,
                ]);
                $this->SendNotification(OrderCancelNotification::class, $order->provider, [
                    'order_id' => $order->id,
                ]);
            }
            else
            {
                $this->SendNotification(OrderUnCancelNotification::class, $order->customer, [
                    'order_id' => $order->id,
                ]);
                $this->SendNotification(OrderUnCancelNotification::class, $order->provider, [
                    'order_id' => $order->id,
                ]);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function updateChatStatus(&$order)
    {
        $chat = $this->chatRoomRepository->getRoomByOrderNotMember($order->id);
        if ($order->is_stopped == self::STOPPED && $chat != null) {
            $chat->update([
                'status' => 'OPEN'
            ]);
            broadcast(new ChatRoomStatusChange($chat->id, 'OPEN'))->toOthers();
        } else if ($order->is_stopped == self::NOT_STOPPED && $chat != null) {
            $chat->update([
                'status' => 'CLOSE'
            ]);
            broadcast(new ChatRoomStatusChange($chat->id, 'CLOSE'))->toOthers();
        }
    }
}
