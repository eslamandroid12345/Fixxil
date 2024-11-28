<?php

namespace App\Http\Services\Api\V1\App\Order\Helpers;

use App\Events\ChatRoomStatusChange;
use App\Http\Enums\OrderStatus;
use App\Http\Traits\Responser;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderChangeActionHelper
{
    use Responser;

    public function __construct(
        private readonly OrderRepositoryInterface    $orderRepository,
        private readonly ChatRoomRepositoryInterface $chatRoomRepository
    )
    {

    }

    public function changeAction($request)
    {
        $data = $request->validated();
        switch ($data['action']) {
            case 'go_to_location' :
                return $this->goToLocation($data['order_id'], $data['action']);
            case 'start_service' :
                return $this->startService($data['order_id'], $data['action']);
            case 'finish_service' :
                return $this->finishService($data['order_id'], $data['action']);
        }
        return 0;
    }

    private function goToLocation($order_id, $action)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderRepository->getById($order_id);
            if (!$order->canGoToLocation)
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $order->update(['action' => $action]);
            DB::commit();
            return $this->responseSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function startService($order_id, $action)
    {
        try
        {
            DB::beginTransaction();
            $order = $this->orderRepository->getById($order_id);
            if (!$order->canStartService)
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $order->update(['action' => $action]);
            DB::commit();
            return $this->responseSuccess();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function finishService($order_id, $action)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderRepository->getById($order_id);
            if (!$order->canFinishService)
                return $this->responseFail(message: __('messages.you are not authorized to do this action'));
            $order->update([
                'action' => $action,
                'status' => OrderStatus::FINISHED->value]);
            $room = $this->chatRoomRepository->getRoomByOrder($order_id);
            $room->update(['status' => 'CLOSE']);
            broadcast(new ChatRoomStatusChange($room->id, 'CLOSE'))->toOthers();
            DB::commit();
            return $this->responseSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
