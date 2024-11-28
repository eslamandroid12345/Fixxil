<?php

namespace App\Http\Controllers\Api\V1\App\Info;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Info\InfoService;

class InfoController extends Controller
{
    public function __construct(
        private readonly InfoService $info,
    )
    {
//        $this->middleware('auth:api-app');
    }

    public function getInfo()
    {
        return $this->info->getInfo();
    }
}
