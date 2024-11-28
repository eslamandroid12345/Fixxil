<?php

namespace App\Http\Controllers\Api\V1\Dashboard\ChatRoomMessage;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\ChatRoomMessage\ChatRoomMessageService;
use Illuminate\Http\Request;

class ChatRoomMessageController extends Controller
{
    public function __construct(
        private readonly ChatRoomMessageService $service
    ){

    }

    public function destroy($id){
        return $this->service->destroy($id);
    }
}
