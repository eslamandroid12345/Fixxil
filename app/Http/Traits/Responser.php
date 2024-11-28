<?php

namespace App\Http\Traits;

use App\Http\Helpers\Http;

trait Responser
{
    private function responseSuccess($status = Http::OK, $message = 'Success', $data = []) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    private function responseFail($status = Http::UNPROCESSABLE_ENTITY, $message = 'Error', $data = []) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    private function responseCustom($status, $message, $data = []) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
