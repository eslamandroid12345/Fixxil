<?php

namespace App\Http\Controllers\Api\V1\App\Social;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Social\SocialService;
use App\Http\Requests\Api\V1\App\Social\SocialRequest;

class SocialController extends Controller
{
    public function __construct(
        private readonly SocialService $social,
    )
    {
    }

    public function redirect($provider)
    {
        return $this->social->redirect($provider);
    }


    public function callbackmobile(SocialRequest $request)
    {
        return $this->social->callbackmobile($request);
    }


    public function callback($provider)
    {
        return $this->social->callback($provider);
    }

    public function checkSocial(Request $request)
    {
        return $this->social->checkSocial($request);
    }
}
