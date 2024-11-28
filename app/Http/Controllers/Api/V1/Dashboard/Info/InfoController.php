<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Info;
use App\Http\Requests\Api\V1\Dashboard\Info\InfoRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Info\InfoService;

class InfoController extends Controller
{
    public function __construct(private readonly InfoService $info)
    {
        $this->middleware('auth:api-manager');
    }

    public function show()
    {
        return $this->info->show();
    }

    public function update(InfoRequest $request)
    {
        return $this->info->update($request);
    }
}
