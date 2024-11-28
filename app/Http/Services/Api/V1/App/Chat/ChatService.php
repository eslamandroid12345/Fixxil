<?php

namespace App\Http\Services\Api\V1\App\Chat;

use App\Http\Requests\Api\V1\App\Chat\ChatRequest;
use App\Http\Requests\Api\V1\App\Chat\LoadMessageRequest;
use App\Http\Requests\Api\V1\App\Chat\ChatMessageRequest;
use App\Http\Traits\Notification;
use App\Notifications\OrderUpdateNotification;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\ChatRoomMessageRepositoryInterface;
use App\Repository\ChatRoomMemberRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use Exception;
use Carbon\Carbon;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Chat\ChatMessageResource;
use App\Http\Resources\V1\App\Chat\ChatProvideResource;
use App\Http\Resources\V1\App\Chat\ChatRoomResource;
use Illuminate\Support\Facades\Log;
use App\Events\PushChatMessageEvent;
use App\Events\ChatRoomEvent;
use Illuminate\Support\Facades\Gate;

abstract class ChatService extends PlatformService
{
    use Responser, Notification;

    public function __construct(

        private readonly FileManagerService                 $fileManagerService,
        private readonly GetService                         $getService,
        private readonly ChatRoomRepositoryInterface        $chatRoomRepository,
        private readonly ChatRoomMemberRepositoryInterface  $chatRoomMemberRepository,
        private readonly ChatRoomMessageRepositoryInterface $chatRoomMessageRepository,
        private readonly UserRepositoryInterface            $userRepository,
    )
    {
    }

    public function provide(ChatRequest $request)
    {
        return $this->getService->handle(ChatProvideResource::class, $this->chatRoomRepository, 'provide', [$request->user_id, $request->order_id], true);
    }

    public function getRooms()
    {
        return $this->getService->handle(ChatRoomResource::class, $this->chatRoomRepository, 'getRooms');
    }

    public function getMessages($room_id)
    {
        $room = $this->chatRoomRepository->getById($room_id);
        if (Gate::allows('access-room', $room)) {
            return $this->getService->handle(ChatMessageResource::class, $this->chatRoomMessageRepository, 'getRoomMessages', [$room_id]);
        } else {
            return $this->responseCustom(401, __('messages.You are not allowed to access this resource'));
        }
    }

    public function loadMoreMessages(LoadMessageRequest $request, $room_id)
    {
        $room = $this->chatRoomRepository->getById($room_id);
        if (Gate::allows('access-room', $room)) {
            return $this->getService->handle(ChatMessageResource::class, $this->chatRoomMessageRepository, 'getRoomMessages', [$room_id, $request->after_message_id]);
        } else {
            return $this->responseCustom(401, __('messages.You are not allowed to access this resource'));
        }
    }

    public function send(ChatMessageRequest $request, $room_id)
    {
        $room = $this->chatRoomRepository->getById($room_id, relations:  ['otherParty.user:id,fcm']);
        if (Gate::allows('access-room', $room)) {
            DB::beginTransaction();
            try {
                $data = $request->validated();
                if ($request->type != 'TEXT') {
                    $data['content'] = $this->uploadNotTextMessage($request->type);
                    unset($data['file']);
                }
                $message = $this->chatRoomMessageRepository->create([
                    'chat_room_id' => $room_id,
                    'user_id' => auth('api-app')->id(),
                    'content' => $data['content'],
                    'type' => $data['type']
                ]);

                $this->chatRoomRepository->update($room_id, ['updated_at' => Carbon::now()]);

                $this->chatRoomMemberRepository->incrementUnread($room_id); // for others

                broadcast(new PushChatMessageEvent($message))->toOthers();


                $this->SendNotification(OrderUpdateNotification::class, $room->otherParty?->user, [
                    'order_id' => $room->order_id,
                    'message' => __('messages.new message '),
                ]);
//                $this->fireRoomEvent($room);

                DB::commit();
                return $this->responseSuccess(data: new ChatMessageResource($message));
            } catch (Exception $e) {
                DB::rollBack();
                Log::warning('send chat error: ' . $e);
                return $this->responseFail(message: __('messages.Something went wrong'));
            }
        } else {
            return $this->responseCustom(401, __('messages.You are not allowed to access this resource'));
        }
    }

    private function uploadNotTextMessage($type)
    {
        return $this->fileManagerService
            ->handle('file', 'messages/' . strtolower($type));
    }

    public function read($room_id)
    {
        $room = $this->chatRoomRepository->getById($room_id);
        if (Gate::allows('access-room', $room)) {
            $this->chatRoomMemberRepository->resetUnread($room_id);
//            $this->fireRoomEvent($room);
            return $this->responseSuccess();
        } else {
            return $this->responseCustom(401, __('messages.You are not allowed to access this resource'));
        }
    }

    private function fireRoomEvent($room)
    {
        $parties = $this->chatRoomMemberRepository->get('chat_room_id', $room->id);

        foreach ($parties as $party) {
            broadcast(new ChatRoomEvent($room, $party->user?->id));
        }
    }

    public function goOnline()
    {
        $this->userRepository->update(auth('api-app')->id(), ['is_online' => true]);

        broadcast(new OnlineStateEvent(auth('api-app')->user(), auth('api-app')->id()));

        return $this->responseSuccess();
    }

    public function goOffline()
    {
        $this->userRepository->update(auth('api-app')->id(), ['is_online' => false]);

        broadcast(new OnlineStateEvent(auth('api-app')->user(), auth('api-app')->id()));

        return $this->responseSuccess();
    }

}
