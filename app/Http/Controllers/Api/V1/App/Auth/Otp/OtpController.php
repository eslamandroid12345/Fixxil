<?php

namespace App\Http\Controllers\Api\V1\App\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Otp\OtpVerifyRequest;
use App\Http\Services\Api\V1\Dashboard\Auth\Otp\OtpService;

class OtpController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService
    )
    {

    }

    public function send()
    {
        $user = auth()->user();
        return $this->otpService->generate($user);
    }
    public function verify(OtpVerifyRequest $request)
    {
        return $this->otpService->verify($request);
    }
}
