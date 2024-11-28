<?php

namespace App\Http\Services\Api\V1\Dashboard\ChatRoomMessage;

use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\ComplainNotification;
use App\Notifications\DeleteMessageNotification;
use App\Repository\ChatRoomMessageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChatRoomMessageService
{
    use Responser,Notification;

    public function __construct(
        private readonly ChatRoomMessageRepositoryInterface $chatRoomMessageRepository
    )
    {
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $message = $this->chatRoomMessageRepository->getById($id);
            $this->SendNotification(DeleteMessageNotification::class, $message->user, [
                'order_id' => $message->room->order_id,
            ]);
            $this->chatRoomMessageRepository->delete($id);
            DB::commit();
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
